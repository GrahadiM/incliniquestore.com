<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        if (!app()->runningInConsole() && Schema::hasTable('web_settings')) {
            View::share('webSetting', WebSetting::first());
        }

        if (!app()->runningInConsole() && Schema::hasTable('products')) {
            View::share('allProducts', Product::with(['category'])->where('status', 'published')->get());
        }

        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        $this->configureRateLimiting();
    }

    protected function configureRateLimiting(): void
    {
        /**
         * GLOBAL RATE LIMITER
         * Berlaku untuk seluruh aplikasi
         */
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(120)
                ->by(
                    optional($request->user())->id
                    ?: $request->ip()
                );
        });

        /**
         * REGISTER RATE LIMITER (ANTI SPAM)
         */
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        /**
         * LOGIN RATE LIMITER
         */
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(10)->by(
                $request->input('email') . '|' . $request->ip()
            );
        });
    }
}
