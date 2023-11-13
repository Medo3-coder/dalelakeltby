<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'HtmlMinifier'], 'as' => 'store.', 'prefix' => 'store'], function () {


    Route::get('/', [SiteController::class, 'index'])->name('site');
    // guest routes
    Route::group(['middleware' => ['guest']], function () {
        Route::get('choose-login'                    , 'AuthController@chooseLogin')->name('chooseLogin');
        Route::get('login'                           , 'AuthController@showLogin')->name('showLogin');
        Route::get('login-employees'                 , 'AuthController@showLoginEmployees')->name('showLoginEmployees');
        Route::get('activate/{country_code}/{phone}' , 'AuthController@activatePage')->name('activatePage');
        Route::post('activate'                       , 'AuthController@activate')->name('activate');
        Route::post('login'                          , 'AuthController@login')->name('login');
        Route::post('login-employees'                , 'AuthController@loginEmployees')->name('loginEmployees');
        Route::post('reset-code'                     , 'AuthController@resetCode')->name('reset-code');
        Route::get('forget-password-show'            , 'AuthController@forgetPasswordShow')->name('forgetPasswordShow');
        Route::post('forget-password'                , 'AuthController@forgetPassword')->name('forgetPassword');
        Route::get('active-code-forget-password-show', 'AuthController@activeCodeForgetPasswordShow')->name('activeCodeForgetPasswordShow');
        Route::get('active-code-forget-password'     , 'AuthController@activeCodeForgetPassword')->name('activeCodeForgetPassword');
        Route::get('register'                        , 'AuthController@register')->name('register');
        Route::post('register-store'                 , 'AuthController@registerStore')->name('register.store');
    });
    // guest routes

    Route::group(['middleware' => ['CheckDashboardAuth']], function () {

        Route::get('logout'                                 , 'AuthController@logout')->name('logout');

        /** Routes Profile **/
        Route::get('/profile'                               , 'ProfileController@index')->name('profile');
        Route::put('/profile/update'                        , 'ProfileController@profileUpdate')->name('profile.update');
        Route::put('/profile/update/store'                  , 'ProfileController@storeUpdate')->name('profile.store.update');
        Route::delete('/profile/delete/store'               , 'ProfileController@storeDelete')->name('profile.store.delete');
        Route::post('/profile/permit/store'                 , 'ProfileController@permitStore')->name('profile.permit.store');
        Route::delete('/profile/permit/delete'              , 'ProfileController@permitDelete')->name('profile.permit.delete');

        Route::group(['middleware' => ['providerCheckPermission']], function () {
            /** Routes Home And  Notifications And Search **/
            Route::get('home'                                   , 'SiteController@home')->name('home');
            Route::get('/notifications'                         , 'SiteController@notifications')->name('notifications');
            Route::post('/search'                               , 'SiteController@search')->name('search');

            /** Routes Products **/
            Route::get('products'                               , 'ProductController@index')->name('products');
            Route::get('products/create'                        , 'ProductController@create')->name('products.create');
            Route::post('products/store'                        , 'ProductController@store')->name('products.store');
            Route::get('products/show/{id}'                     , 'ProductController@show')->name('products.show');
            Route::get('products/edit/{id}'                     , 'ProductController@edit')->name('products.edit');
            Route::put('products/update/{id}'                   , 'ProductController@update')->name('products.update');
            Route::delete('products/delete'                     , 'ProductController@delete')->name('products.delete');

            /** Routes Products Features **/
            Route::get('products/features/{id}'                 , 'ProductController@features')->name('products.features');
            Route::post('products/features/{id}/update'         , 'ProductController@featuresUpdate')->name('products.features.update');
            Route::delete('products/features/{id}/delete'       , 'ProductController@featuresDelete')->name('products.features.delete');

            /** Routes Products Groups **/
            Route::get('products/groups/{id}'                   , 'ProductController@groups')->name('products.groups');
            Route::post('products/groups/{id}/update'           , 'ProductController@groupsUpdate')->name('products.groups.update');
            Route::delete('products/groups/{id}/delete'         , 'ProductController@groupsDelete')->name('products.groups.delete');

            /** Routes Products Additions **/
            Route::get('products/additions/{id}'                , 'ProductController@additions')->name('products.additions');
            Route::post('products/additions/{id}/update'        , 'ProductController@additionsUpdate')->name('products.additionsUpdate');

            /** Routes Categories **/
            Route::get('categories'                             , 'CategoryController@index')->name('categories');
            Route::get('categories/create'                      , 'CategoryController@create')->name('categories.create');
            Route::post('categories/store'                      , 'CategoryController@store')->name('categories.store');
            Route::get('categories/edit/{id}'                   , 'CategoryController@edit')->name('categories.edit');
            Route::put('categories/update/{id}'                 , 'CategoryController@update')->name('categories.update');
            Route::delete('categories/delete'                   , 'CategoryController@delete')->name('categories.delete');

            /** Routes Coupons **/
            Route::get('coupons'                                , 'CouponController@index')->name('coupons');
            Route::get('coupons/create'                         , 'CouponController@create')->name('coupons.create');
            Route::post('coupons/store'                         , 'CouponController@store')->name('coupons.store');
            Route::get('coupons/edit/{id}'                      , 'CouponController@edit')->name('coupons.edit');
            Route::put('coupons/update/{id}'                    , 'CouponController@update')->name('coupons.update');
            Route::delete('coupons/delete'                      , 'CouponController@delete')->name('coupons.delete');
            Route::post('coupons/change/status/closed'          , 'CouponController@changeStatusClosed')->name('coupons.changeStatusClosed');
            Route::post('coupons/change/status/available'       , 'CouponController@changeStatusAvailable')->name('coupons.changeStatusAvailable');

            /** Routes Orders **/
            Route::get('orders/pending'                         , 'OrderController@index')->name('orders.pending');
            Route::get('orders/accepted'                        , 'OrderController@index')->name('orders.accepted');
            Route::get('orders/prepared'                        , 'OrderController@index')->name('orders.prepared');
            Route::get('orders/rejected'                        , 'OrderController@index')->name('orders.rejected');
            Route::get('orders/show/{id}'                       , 'OrderController@show')->name('orders.show');
            Route::post('orders/statusAccepted'                 , 'OrderController@statusAccepted')->name('orders.statusAccepted');
            Route::post('orders/statusRejected'                 , 'OrderController@statusRejected')->name('orders.statusRejected');
            Route::post('orders/statusPrepared'                 , 'OrderController@statusPrepared')->name('orders.statusPrepared');


            /** Routes Reports **/
            Route::get('reports/orders/being-paid'              , 'ReportController@beingPaid')->name('reports.beingPaid');
            Route::get('reports/orders/paid'                    , 'ReportController@paid')->name('reports.paid');
            Route::get('reports/orders/income'                  , 'ReportController@income')->name('reports.income');
            Route::get('reports/orders/show/{id}'               , 'ReportController@orderShow')->name('reports.show');
            Route::post('reports/order/statusPaid/{id}'         , 'ReportController@statusPaid')->name('orders.statusPaid');




            /** Routes Offers **/
            Route::get('offers'                                 , 'OfferController@index')->name('offers');
            Route::get('offers/show/{id}'                       , 'OfferController@show')->name('offers.show');
            Route::get('offers/product/show/{id}'               , 'OfferController@productShow')->name('offers.product.show');
            Route::get('offers/create'                          , 'OfferController@create')->name('offers.create');
            Route::post('offers/store'                          , 'OfferController@store')->name('offers.store');
            Route::get('offers/edit/{id}'                       , 'OfferController@edit')->name('offers.edit');
            Route::put('offers/update/{id}'                     , 'OfferController@update')->name('offers.update');
            Route::delete('offers/delete'                       , 'OfferController@delete')->name('offers.delete');

            /** Routes Suggestions **/
            Route::get('/suggestions'                           , 'SuggestionController@index')->name('suggestions.index');
            Route::post('/suggestions/send'                     , 'SuggestionController@send')->name('suggestions.send');

            /** Routes Rules **/
            Route::get('/rules'                                 , 'RuleController@index')->name('rules.index');
            Route::get('/rules/add'                             , 'RuleController@add')->name('rules.add');
            Route::post('/rules/store'                          , 'RuleController@store')->name('rules.store');
            Route::put('/rules/change-password'                 , 'RuleController@changePassword')->name('rules.changePassword');
            Route::delete('/rules/delete/{id}'                  , 'RuleController@delete')->name('rules.delete');

        });



    });

});
