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

    Route::controller(App\Http\Controllers\Frontend\LocationController::class)->prefix('location')->name('location.')->group(function () {
        // Route::get('/', 'index')->name('index');
        Route::post('/set-selected-store', 'selected_store')->name('selected_store');
    });

    Route::controller(App\Http\Controllers\Frontend\ProductController::class)->prefix('shop')->name('shop.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}', 'detail')->name('detail');

        Route::controller(App\Http\Controllers\Frontend\CategoryController::class)->prefix('categories')->name('category.')->group(function () {
            Route::get('/{slug}', 'index')->name('index');
        });
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
                Route::patch('/update/{cart}', 'update')->name('update');
                Route::delete('/{cart}', 'destroy')->name('destroy');
            });

            Route::controller(App\Http\Controllers\Frontend\CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
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
