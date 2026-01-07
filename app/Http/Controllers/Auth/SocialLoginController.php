<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // ---------- NAVER ----------
    public function naverRedirect()
    {
        // при необходимости: ->scopes(['name','email'])
        return Socialite::driver('naver')->redirect();
    }

    public function naverCallback()
    {
        $socialiteUser = Socialite::driver('naver')->user(); // ->stateless() если SPA/API

        return $this->handleSocialUser('naver', $socialiteUser);
    }

    // ---------- KAKAO ----------
    public function kakaoRedirect()
    {
        // Для email у Kakao часто нужен явный скоуп:
        return Socialite::driver('kakao')
            ->scopes(['profile_nickname'])
            ->redirect();
    }

    public function kakaoCallback()
    {
        $socialiteUser = Socialite::driver('kakao')->user(); // ->stateless() если SPA/API

        return $this->handleSocialUser('kakao', $socialiteUser);
    }

    // ---------- Общий обработчик ----------
    protected function handleSocialUser(string $provider, $socialiteUser)
    {
        // ВАЖНО: у Kakao/Naver email может быть NULL (не выдан по согласию). Обработаем это.
        $providerId = $socialiteUser->getId();
        $email      = $socialiteUser->getEmail();        // может быть null
        $name       = $socialiteUser->getName() ?: $socialiteUser->getNickname() ?: $provider.'-user';
        $avatar     = $socialiteUser->getAvatar();

        // Ищем по provider_id или по email (если есть)
        $query = User::query();
        $query->when($provider === 'naver', fn($q) => $q->orWhere('naver_id', $providerId));
        $query->when($provider === 'kakao', fn($q) => $q->orWhere('kakao_id', $providerId));
        if ($email) {
            $query->orWhere('email', $email);
        }

        $user = $query->first();

        if (!$user) {
            // Если email не пришёл, можно:
            // 1) сделать поле email nullable в миграции и создать пользователя без email,
            // 2) или сгенерировать псевдо-email (НЕ рекомендуется для прод),
            // 3) или отправить на страницу, где попросить указать email вручную.
            $user = User::create([
                'name'  => $name,
                'email' => $email, // пусть будет null, если миграция позволяет
                'password' => Hash::make(Str::random(32)),
                'avatar'   => $avatar,
                // сохраним provider_id в соответствующее поле
                $provider . '_id' => $providerId,
            ]);

            // Назначаем роль обычного пользователя
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('user'); // убедись, что роль существует
            }

            // Отметить email как подтверждённый, если пришёл и доверяем провайдеру
            if ($email && method_exists($user, 'markEmailAsVerified')) {
                $user->markEmailAsVerified();
            }
        } else {
            // Привязываем provider_id, если ранее его не было
            $col = $provider . '_id';
            if (!$user->$col) {
                $user->$col = $providerId;
                if (!$user->avatar && $avatar) {
                    $user->avatar = $avatar;
                }
                $user->save();
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }
}
