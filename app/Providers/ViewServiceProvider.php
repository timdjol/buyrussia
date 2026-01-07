<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('contacts', Contact::first());
        });
        View::composer('index', function ($view) {
            $view->with('contacts', Contact::first());
        });
        View::composer('pages.community', function ($view) {
            $view->with('contacts', Contact::first());
        });
        View::composer('pages.community_ads', function ($view) {
            $view->with('contacts', Contact::first());
        });
        View::composer('pages.community_law', function ($view) {
            $view->with('contacts', Contact::first());
        });
        View::composer('pages.post', function ($view) {
            $view->with('contacts', Contact::first());
        });
        View::composer('pages.ad', function ($view) {
            $view->with('contacts', Contact::first());
        });
    }
}
