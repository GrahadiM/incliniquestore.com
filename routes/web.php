<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:global')->name('frontend.')->group(function () {
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

    Route::controller(App\Http\Controllers\Frontend\MidtransCallbackController::class)->prefix('payment')->name('payment.')->group(function () {
        Route::post('/midtrans/callback', 'midtransCallback')->name('midtrans.callback');
    });
});

Route::middleware(['auth', 'block.admin.login'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['active.user', 'role:customer|member'])->group(function () {
        Route::name('frontend.')->group(function () {
            Route::controller(App\Http\Controllers\Frontend\CartController::class)->prefix('cart')->name('cart.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/add', 'add')->name('add');
                Route::patch('/update/{cart}', 'update')->name('update');
                Route::delete('/{cart}', 'destroy')->name('destroy');
            });

            Route::controller(App\Http\Controllers\Frontend\CareerController::class)->prefix('career')->name('career.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/apply', 'apply')->name('apply');
            });

            // Rate Limiter Request for checkout, order tracking, etc
            Route::middleware('throttle:global')->group(function () {
                Route::controller(App\Http\Controllers\Frontend\CheckoutController::class)->prefix('checkout')->name('checkout.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/process', 'store')->name('store');
                    Route::post('/voucher', 'applyVoucher')->name('voucher');
                });

                Route::controller(App\Http\Controllers\Frontend\OrderTrackingController::class)->prefix('order-tracking')->name('order.tracking.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'submit')->name('submit');
                });
            });
        });

        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

            Route::controller(App\Http\Controllers\Customer\ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/edit', 'edit')->name('edit');
                Route::patch('/update', 'update')->name('update');
                Route::patch('/update-password', 'updatePassword')->name('update.password');
            });

            Route::controller(App\Http\Controllers\Customer\AddressController::class)->prefix('address')->name('address.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{address}/edit', 'edit')->name('edit');
                Route::patch('/{address}', 'update')->name('update');
                Route::delete('/{address}', 'destroy')->name('destroy');
                Route::post('/{address}/set-default', 'setDefault')->name('setDefault');
            });

            Route::controller(App\Http\Controllers\Customer\OrderController::class)->prefix('orders')->name('orders.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/datatable', 'datatable')->name('datatable');
                Route::get('/{order}', 'detail')->name('detail');
                Route::post('/{order}/cancel', 'cancel')->name('cancel');
                Route::post('/{order}/payment-token', 'generateSnapToken')->name('generateSnapToken');
            });
        });
    });
});

/* MIDTRANS CALLBACK */
// Route::post('/payment/midtrans/callback', [App\Http\Controllers\Frontend\MidtransCallbackController::class, 'handle']);

/* ORDER EXPIRY (CRON) */
// Route::get('/cron/order-expiry', [OrderExpiryController::class, 'cancelPending']);

require __DIR__.'/auth.php';
