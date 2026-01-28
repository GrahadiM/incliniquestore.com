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
            Route::controller(App\Http\Controllers\Frontend\CartController::class)->group(function () {
                Route::get('/cart', 'index')->name('cart.index');
                Route::post('/cart/add', 'add')->name('cart.add');
            });

            Route::controller(App\Http\Controllers\Frontend\CheckoutController::class)->group(function () {
                Route::get('/checkout', 'index')->name('checkout.index');
                Route::post('/checkout', 'store')->name('checkout.store');
                Route::post('/checkout/success', 'success')->name('checkout.success');
            });

            Route::controller(App\Http\Controllers\Frontend\OrderTrackingController::class)->group(function () {
                Route::get('/order-tracking', 'index')->name('order.tracking.index');
                Route::post('/order-tracking', 'submit')->name('order.tracking.submit');
            });

            Route::controller(App\Http\Controllers\Frontend\CareerController::class)->group(function () {
                Route::get('/career', 'index')->name('career.index');
                Route::post('/career/apply', 'apply')->name('career.apply');
            });
        });

        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        });
    });
});

require __DIR__.'/auth.php';
