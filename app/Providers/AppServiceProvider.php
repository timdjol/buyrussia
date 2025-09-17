<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('routeactive', function($route){
            return "<?php echo Route::currentRouteNamed($route) ? 'class=\"current\"' : ''  ?>";
        });
        Blade::if('admin', function(){
            return Auth::user()->hasRole('Admin');
        });
        Blade::if('manager', function(){
            return Auth::user()->hasRole('Manager');
        });

    }
}
