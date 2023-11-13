<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'HtmlMinifier'], 'as' => 'lab.', 'prefix' => 'lab'], function () {

    Route::get('/', [SiteController::class, 'index'])->name('site');
    // guest routes
    Route::group(['middleware' => ['guest']], function () {
        Route::get('choose-login', 'AuthController@chooseLogin')->name('chooseLogin');
        Route::get('login', 'AuthController@showLogin')->name('showLogin');
        Route::post('login', 'AuthController@login')->name('login');
        Route::get('login-employees', 'AuthController@showLoginEmployees')->name('showLoginEmployees');
        Route::post('login-employees', 'AuthController@loginEmployees')->name('loginEmployees');
        Route::get('forget-password', 'AuthController@forgetPassword')->name('forgetPassword');
        Route::post('forget-password-send-code', 'AuthController@forgetPasswordSendCode')->name('forgetPasswordSendCode');
        Route::get('forget-password-check-code', 'AuthController@forgetPasswordCheckCode')->name('forgetPasswordCheckCode');
        Route::post('forget-password-check-code', 'AuthController@postForgetPasswordCheckCode')->name('postForgetPasswordCheckCode');
        Route::get('forget-password-reset', 'AuthController@forgetPasswordReset')->name('forgetPasswordReset');
        Route::post('forget-password-reset', 'AuthController@postForgetPasswordReset')->name('postForgetPasswordReset');
        Route::get('register', 'AuthController@register')->name('register');
        Route::post('register', 'AuthController@postRegister')->name('postRegister');
    });
    // guest routes

    Route::get('activate', 'AuthController@activate')->name('activate');
    Route::post('resend-code', 'AuthController@resendCode')->name('resendCode');
    Route::post('activate', 'AuthController@postActivate')->name('postActivate');

    Route::group(['middleware' => ['CheckDashboardAuth']], function () {
        Route::get('logout', 'AuthController@logout')->name('logout');

        /** Routes Profile **/
        Route::get('/profile', 'ProfileController@index')->name('profile');
        Route::put('/profile/update', 'ProfileController@profileUpdate')->name('profile.update');
        Route::put('/profile/update/lab', 'ProfileController@labUpdate')->name('profile.store.update');
        Route::delete('/profile/delete/lab', 'ProfileController@labDelete')->name('profile.store.delete');
        Route::post('/profile/permit/store', 'ProfileController@permitStore')->name('profile.permit.store');
        Route::delete('/profile/permit/delete', 'ProfileController@permitDelete')->name('profile.permit.delete');
        Route::post('/search', 'SiteController@search')->name('search');

        Route::get('/medical-tets/getSubCategory/{id}', 'MedicalTestController@getSubCategory')->name('medicalTests.getSubCategory');

        Route::group(['middleware' => ['providerCheckPermission']], function () {
            Route::get('home', 'SiteController@home')->name('home');
            Route::get('notifications', 'SiteController@notifications')->name('notifications');
            Route::post('refuse-reservation', 'ReservationController@refuseReservation')->name('refuseReservation');
            Route::get('accept-reservation/{reservation_id}', 'ReservationController@acceptReservation')->name('acceptReservation');
            Route::get('new-reservations', 'ReservationController@newReservations')->name('newReservations');
            Route::get('accepted-reservations', 'ReservationController@acceptedReservations')->name('acceptedReservations');
            Route::get('reservation-details/{id}', 'ReservationController@reservationDetails')->name('reservationDetails');
            Route::put('patient-enter/{reservation_id}', 'ReservationController@patientEnter')->name('reservations.patientEnter');
            Route::get('add-reservation-result/{reservation_id}', 'ReservationController@addReservationResult')->name('reservations.addReservationResult');
            Route::post('add-reservation-result}', 'ReservationController@setReservationFirstResult')->name('reservations.setReservationFirstResult');
            Route::post('update-reservation-result}', 'ReservationController@updateReservationResult')->name('reservations.updateReservationResult');
            Route::put('finish-reservation/{reservation_id}', 'ReservationController@finishReservation')->name('reservations.finishReservation');

//      own medical-tests
            Route::group(['prefix' => 'medical-tests', 'as' => 'medicalTests.'], function () {
                Route::get('/', 'MedicalTestController@index')->name('index');
                Route::get('create', 'MedicalTestController@create')->name('create');
                Route::post('create', 'MedicalTestController@store')->name('store');
                Route::get('{id}/edit', 'MedicalTestController@edit')->name('edit');
                Route::put('{id}', 'MedicalTestController@update')->name('update');
                Route::delete('{id}', 'MedicalTestController@delete')->name('delete');

                Route::group(['prefix' => 'tests', 'as' => 'tests.'], function () {
                    Route::get('/', 'TestController@index')->name('index');
                    Route::get('create', 'TestController@create')->name('create');
                    Route::post('create', 'TestController@store')->name('store');
                    Route::get('{id}/edit', 'TestController@edit')->name('edit');
                    Route::put('{id}', 'TestController@update')->name('update');
                    Route::delete('{id}', 'TestController@delete')->name('delete');
                });
            });

            Route::group(['prefix' => 'rules', 'as' => 'rules.'], function () {
                Route::get('/', 'RuleController@index')->name('index');
                Route::get('/add', 'RuleController@add')->name('add');
                Route::post('/store', 'RuleController@store')->name('store');
                Route::put('/change-password', 'RuleController@changePassword')->name('changePassword');
                Route::delete('/delete/{id}', 'RuleController@delete')->name('delete');
            });

            Route::group(['prefix' => 'medical-devices', 'as' => 'medicalDevices.'], function () {
                Route::get('/offers', 'MedicalDeviceController@offers')->name('offers');
                Route::get('/offers/{id}/details', 'MedicalDeviceController@offerDetails')->name('offerDetails');
                Route::get('/my-orders', 'MedicalDeviceController@myOrders')->name('myOrders');
                Route::get('/my-order/{id}/details', 'MedicalDeviceController@myOrderDetails')->name('myOrderDetails');
            });

            Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
                Route::get('/finished', 'ReportController@finished')->name('finished');
                Route::get('/reservation-details/{id}', 'ReportController@reservationDetails')->name('reservationDetails');
                Route::get('/income', 'ReportController@income')->name('income');
                Route::get('/order/pending-payment', 'ReportController@ordersPendingPayment')->name('orders.pendingPayment');
                Route::get('/order/paid', 'ReportController@ordersPaid')->name('orders.paid');
                Route::get('/order/details/{id}', 'ReportController@orderDetails')->name('orders.details');
            });

            Route::group(['prefix' => 'suggestions', 'as' => 'suggestions.'], function () {
                Route::get('/', 'SuggestionController@index')->name('index');
                Route::post('/send', 'SuggestionController@send')->name('send');
            });

            Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
                Route::get('/', 'CartController@index')->name('index');
                Route::post('/add-offer/{offer_id}', 'CartController@addOffer')->name('addOffer');
                Route::get('/make-order-get-data/{store_id}', 'CartController@makeOrderGetData')->name('makeOrderGetData');
                Route::post('/change', 'CartController@change')->name('change');
                Route::post('/save-coupon', 'CartController@saveCoupon')->name('saveCoupon');
                Route::post('/delete-coupon', 'CartController@deleteCoupon')->name('deleteCoupon');
            });

            Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
                Route::post('/make-order', 'OrderController@make')->name('make');
            });
        });

    });

});
