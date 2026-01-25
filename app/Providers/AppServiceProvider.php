<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\WebSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
    }
}
