<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin', 'as' => 'admin.'],function(){


    Route::get('dashboard',[AdminDashboardController::class,'index'])->name('dashboard');

    //profile route
    Route::get('profile',[ProfileController::class,'index'])->name('profile');
    Route::put('profile',[ProfileController::class,'updateProfile'])->name('profile.update');

    Route::put('profile/password',[ProfileController::class,'changePassword'])->name('profile.password.update');

    //Slider routes
    Route::resource('slider',SliderController::class);
    //Why choose us routes
    Route::put('why-choose-title-update',[WhyChooseUsController::class,'updateTitle'])->name('why-choose-title.update');
    Route::resource('why-choose-us',WhyChooseUsController::class);

    //Product category routes
    Route::resource('category',CategoryController::class);

    //Product routes
    Route::resource('product',ProductController::class);

    //Product_Gallery routes
    Route::get('product-gallery{product}',[ProductGalleryController::class,'index'])->name('product.gallery.show-index');
    Route::resource('product-gallery',ProductGalleryController::class);

    //Product_Size routes
    Route::get('product-size{product}',[ProductSizeController::class,'index'])->name('product.size.show-index');
    Route::resource('product-size',ProductSizeController::class);

    //Product_Option routes
    Route::resource('product-option',ProductOptionController::class);
    //Coupon routes
    Route::resource('coupon',CouponController::class);

    //payment routes
    Route::get('payment-gateway-setting',[PaymentGatewaySettingController::class,'index'])->name('payment-gateway-setting.index');
    Route::put('paypal-setting',[PaymentGatewaySettingController::class,'paypalSettingUpdate'])->name('paypal-setting.update');

    //setting routes
    Route::get('setting',[SettingController::class,'index'])->name('setting.index');
    Route::put('setting',[SettingController::class,'updateGeneralSetting'])->name('general-setting.update');

    //delivery routes
    Route::resource('delivery-area', DeliveryController::class);
});

