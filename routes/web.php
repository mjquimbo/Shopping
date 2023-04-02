<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/verify-login', 'verifyLogIn')->name('verify.login');
    Route::get('/signup', 'signUp')->name('signup');
    Route::post('/verify-signup', 'verifySignUp')->name('verify.signup');
    Route::get('signout', 'signOut')->name('signout');
});

Route::controller(ProductController::class)->group(function () {
    Route::middleware(['user'])->group(function () {
        Route::get('/', 'index')->name('products.index');
        Route::group([
            'prefix' => 'products'
        ], function () {
            Route::get('/{product}', 'show')->name('products.show');
            Route::post('/add-product/{product}', 'addProduct');
            Route::post('/delete-product/{product}', 'deleteProduct');
            Route::post('/delete-all-product/{product}', 'deleteAllProduct');
        });
    });
});

Route::controller(CartController::class)->group(function () {
    Route::group([
        'prefix' => 'cart'
    ], function () {
        Route::middleware(['user'])->group(function () {
            Route::get('/', 'index')->name('carts.index');
            Route::get('/fetch-cart', 'fetchCart');
        });
    });
});

Route::controller(PaymentController::class)->group(function () {
    Route::group([
        'prefix' => 'cart'
    ], function () {
        Route::middleware(['auth', 'user'])->group(function () {
            Route::post('/checkout', 'checkout')->name('payments.checkout');
            Route::get('/success', 'success')->name('payments.success');
        });
    });
});


Route::controller(AdminController::class)->group(function () {
    Route::group([
        'prefix' => 'admin'
    ], function () {
        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/', 'index')->name('admin.index');
            Route::post('/upload-image', 'uploadImage');
            Route::post('/orders', 'orders');
        });
    });
});




Route::get('/contact', function () {
    return view('about.contact');
});


// Route::get('/admin', function () {
//     return view('admin.index');
// });
