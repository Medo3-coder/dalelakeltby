<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'HtmlMinifier'], 'as' => 'pharmacy.', 'prefix' => 'pharmacy'], function () {

    Route::get('/', [SiteController::class, 'index'])->name('site');
    // guest routes
    Route::group(['middleware' => ['guest']], function () {
        Route::get('choose-login', 'AuthController@chooseLogin')->name('chooseLogin');
        Route::get('login', 'AuthController@showLogin')->name('showLogin');
        Route::get('activate', 'AuthController@activate')->name('activate');
        Route::post('resend-code', 'AuthController@resendCode')->name('resendCode');
        Route::post('activate', 'AuthController@postActivate')->name('postActivate');
        Route::post('login', 'AuthController@login')->name('login');
        Route::get('forget-password', 'AuthController@forgetPassword')->name('forgetPassword');
        Route::post('forget-password-send-code', 'AuthController@forgetPasswordSendCode')->name('forgetPasswordSendCode');
        Route::get('forget-password-check-code', 'AuthController@forgetPasswordCheckCode')->name('forgetPasswordCheckCode');
        Route::post('forget-password-check-code', 'AuthController@postForgetPasswordCheckCode')->name('postForgetPasswordCheckCode');
        Route::get('forget-password-reset', 'AuthController@forgetPasswordReset')->name('forgetPasswordReset');
        Route::post('forget-password-reset', 'AuthController@postForgetPasswordReset')->name('postForgetPasswordReset');
        Route::get('register', 'AuthController@register')->name('register');
        Route::get('sub-specialities/{id}', 'AuthController@getSubSpecialities')->name('getSubSpecialities');
        Route::post('register', 'AuthController@postRegister')->name('postRegister');
    });
    // guest routes

    Route::group(['middleware' => ['CheckDashboardAuth']], function () {

        Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('profile', 'AuthController@profile')->name('profile');
        Route::post('/search', 'SiteController@search')->name('search');

        /** Routes Profile **/
        Route::get('/profile', 'ProfileController@index')->name('profile');
        Route::put('/profile/update', 'ProfileController@profileUpdate')->name('profile.update');
        Route::put('/profile/update/pharmacy', 'ProfileController@pharmacyUpdate')->name('profile.store.update');
        Route::delete('/profile/delete/pharmacy', 'ProfileController@pharmacyDelete')->name('profile.store.delete');
        Route::post('/profile/permit/store', 'ProfileController@permitStore')->name('profile.permit.store');
        Route::post('/profile/permit/update', 'ProfileController@permitUpdate')->name('profile.permit.update');
        Route::delete('/profile/permit/delete', 'ProfileController@permitDelete')->name('profile.permit.delete');

        Route::group(['middleware' => ['providerCheckPermission']], function () {
            Route::get('home', 'SiteController@home')->name('home');
            Route::get('notifications', 'SiteController@notifications')->name('notifications');

            Route::group(['prefix' => 'rules', 'as' => 'rules.'], function () {
                Route::get('/', 'RuleController@index')->name('index');
                Route::get('/add', 'RuleController@add')->name('add');
                Route::post('/store', 'RuleController@store')->name('store');
                Route::put('/change-password', 'RuleController@changePassword')->name('changePassword');
                Route::delete('/delete/{id}', 'RuleController@delete')->name('delete');
            });

            Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
                Route::get('/', 'CartController@index')->name('index');
                Route::post('/add-offer/{offer_id}', 'CartController@addOffer')->name('addOffer');
                Route::post('/add-product/{product_id}', 'CartController@addProduct')->name('addProduct');
                Route::get('/make-order-get-data/{store_id}', 'CartController@makeOrderGetData')->name('makeOrderGetData');
                Route::post('/change', 'CartController@change')->name('change');
                Route::post('/save-coupon', 'CartController@saveCoupon')->name('saveCoupon');
                Route::post('/delete-coupon', 'CartController@deleteCoupon')->name('deleteCoupon');
                Route::post('/delete-product', 'OrderController@deleteProduct')->name('deleteProduct');
            });

            Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
                Route::post('/make-order', 'OrderController@make')->name('make');

            });

            Route::group(['prefix' => 'my-orders', 'as' => 'myOrders.'], function () {
                Route::get('/pending', 'OrderController@pending')->name('pending');
                Route::get('/accepted', 'OrderController@accepted')->name('accepted');
                Route::get('/prepared', 'OrderController@prepared')->name('prepared');
                Route::get('/rejected', 'OrderController@rejected')->name('rejected');
                Route::get('/details/{id}', 'OrderController@details')->name('details');
                Route::post('/cancel/{id}', 'OrderController@cancel')->name('cancel');
            });

            Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
                Route::get('/order/pending-payment', 'ReportController@ordersPendingPayment')->name('orders.pendingPayment');
                Route::get('/order/paid', 'ReportController@ordersPaid')->name('orders.paid');
                Route::get('/order/details/{id}', 'ReportController@orderDetails')->name('orders.details');
            });

            Route::group(['prefix' => 'stores', 'as' => 'stores.'], function () {
                Route::get('/', 'StoreController@index')->name('index');
                Route::get('/details/{id}', 'StoreController@details')->name('details');
                Route::get('/proucts', 'StoreController@products')->name('products');
            });

            Route::group(['prefix' => 'suggestions', 'as' => 'suggestions.'], function () {
                Route::get('/', 'SuggestionController@index')->name('index');
                Route::post('/send', 'SuggestionController@send')->name('send');
            });

        });
    });

});
