<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Если это SPA / API, используйте ->stateless()
        $googleUser = Socialite::driver('google')->user();

        // Попытка найти пользователя по google_id или email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (!$user) {
            // Новый пользователь
            $user = User::create([
                'name'      => $googleUser->getName() ?: $googleUser->getNickname(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                // Пароль можно сгенерировать случайно, т.к. вход будет через Google
                'password'  => bcrypt(str()->random(32)),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            $user->assignRole('user');
        } else {
            // Связываем google_id, если ещё не связан
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->avatar = $user->avatar ?: $googleUser->getAvatar();
                $user->save();
            }
        }

        Auth::login($user, remember: true);

        return redirect()->intended('/'); // куда вести после входа
    }
}
