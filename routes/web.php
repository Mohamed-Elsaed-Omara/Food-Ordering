<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth' ],function () {

    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::put('profile', [ProfileController::class,'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class,'updatePassword'])->name('profile.password.update');
    Route::post('profile/avatar', [ProfileController::class,'updateAvatar'])->name('profile.avatar.update');
    Route::post('address',[DashboardController::class,'createAddress'])->name('address.create');
    Route::put('address/{id}/update',[DashboardController::class,'updateAddress'])->name('address.update');
    Route::delete('address/{id}',[DashboardController::class,'deleteAddress'])->name('address.destroy');
});

Route::group(['middleware' => 'guest'],function(){

    Route::get('admin/login', [AdminController::class, 'index'])->name('admin.login');
});
Route::get('admin/dashboard',[AdminDashboardController::class,'index'])->middleware(['auth','role:admin'])->name('admin.dashboard');

require __DIR__.'/auth.php';

/* Show Home Page */
Route::get('/', [FrontendController::class,'index'])->name('home');

/* Show Product Details page */
Route::get('/product/{slug}',[FrontendController::class,'showProduct'])->name('product.show');
Route::get('load-product/{productId}',[FrontendController::class, 'loadProductModel'])->name('load-product-model');

/* Add To Cart Route */
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('get-cart-products', [CartController::class, 'modelAddToCart'])->name('get-cart-products');
Route::get('cart-product-remove/{rowId}', [CartController::class, 'cartProductRemove'])->name('cart-product-remove');

/* Cart Page Route */
Route::get('cart',[CartController::class, 'index'])->name('cart');
Route::post('cart-update-qty',[CartController::class, 'cartQtyUpdate'])->name('cart.quentity-update');
Route::get('cart-destroy',[CartController::class, 'cartDestroy'])->name('cart.destroy');

/* Coupon Route */
Route::post('coupon-apply', [CartController::class, 'couponApply'])->name('coupon.apply');
Route::get('destroy-coupon', [CartController::class, 'destroyCoupon'])->name('destroy-coupon');


Route::group(['middleware' => 'auth'], function () {

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('checkout/{id}/delivery-cal', [CheckoutController::class, 'checkoutDeliveryCal'])->name('checkout.delivery-cal');
    Route::post('checkout', [CheckoutController::class, 'redirectCheckout'])->name('checkout.redirect');

    /* Payment Route */
    Route::get('payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('make-payment', [PaymentController::class, 'makePayment'])->name('make-payment');

    Route::get('paypal/payment',[PaymentController::class,'payWithPaypal'])->name('paypal.payment');
    Route::get('paypal/success',[PaymentController::class,'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel',[PaymentController::class,'paypalCancel'])->name('paypal.cancel');

});
