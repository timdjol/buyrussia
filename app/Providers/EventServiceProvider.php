<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Kakao\KakaoExtendSocialite;
use SocialiteProviders\Naver\NaverExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SocialiteWasCalled::class => [
            KakaoExtendSocialite::class,
            NaverExtendSocialite::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
