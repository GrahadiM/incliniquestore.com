<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::controller(App\Http\Controllers\FrontendController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
        Route::get('/career', 'career')->name('career');
        Route::get('/faq', 'faq')->name('faq');
        Route::get('/about', 'about')->name('about');
        Route::get('/contact', 'contact')->name('contact');
        Route::get('/privacy-policy', 'privacyPolicy')->name('privacy.policy');
        Route::get('/terms-and-conditions', 'termsAndConditions')->name('terms.and.conditions');
    });

    Route::controller(App\Http\Controllers\Frontend\LocationController::class)->group(function () {
        Route::get('/locations', 'index')->name('locations.index');
    });

    Route::controller(App\Http\Controllers\Frontend\ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('product.index');
        Route::get('/products/{slug}', 'detail')->name('product.detail');
        Route::get('/categories/{slug}', 'category')->name('product.category');
    });

    Route::controller(App\Http\Controllers\Frontend\CompareController::class)->group(function () {
        Route::get('/compare', 'index')->name('compare.index');
    });

    Route::controller(App\Http\Controllers\Frontend\BlogController::class)->group(function () {
        Route::get('/blog', 'index')->name('blog.index');
        Route::get('/blog/{slug}', 'detail')->name('blog.detail');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['active.user', 'role:customer|member'])->group(function () {
        Route::name('frontend.')->group(function () {
            Route::controller(App\Http\Controllers\Frontend\CartController::class)->prefix('cart')->name('cart.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/add', 'add')->name('add');
                Route::patch('/{cart}', 'update')->name('update');
                Route::delete('/{cart}', 'destroy')->name('destroy');
            });

            Route::controller(App\Http\Controllers\Frontend\CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::post('/success', 'success')->name('success');
            });

            Route::controller(App\Http\Controllers\Frontend\OrderTrackingController::class)->prefix('order-tracking')->name('order.tracking.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'submit')->name('submit');
            });

            Route::controller(App\Http\Controllers\Frontend\CareerController::class)->prefix('career')->name('career.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/apply', 'apply')->name('apply');
            });
        });

        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        });
    });
});

require __DIR__.'/auth.php';
