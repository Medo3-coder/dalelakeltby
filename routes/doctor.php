<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'HtmlMinifier'], 'as' => 'doctor.', 'prefix' => 'doctor'], function () {

    Route::get('/', [SiteController::class, 'index'])->name('site');
    // guest routes
    Route::group(['middleware' => ['guest:doctor']], function () {
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

        /** Routes Profile **/
        Route::get('profile/sub-specialities/{id}'          , 'ProfileController@getSubSpecialities')->name('profile.getSubSpecialities');
        Route::get('/profile'                               , 'ProfileController@index')->name('profile');
        Route::put('/profile/update'                        , 'ProfileController@profileUpdate')->name('profile.update');
        Route::put('/profile/update/doctor'                 , 'ProfileController@doctorUpdate')->name('profile.store.update');
        Route::delete('/profile/delete/doctor'              , 'ProfileController@doctorDelete')->name('profile.store.delete');
        Route::post('/profile/permit/store'                 , 'ProfileController@permitStore')->name('profile.permit.store');
        Route::post('/profile/permit/update'                , 'ProfileController@permitUpdate')->name('profile.permit.update');
        Route::delete('/profile/permit/delete'              , 'ProfileController@permitDelete')->name('profile.permit.delete');



        Route::group(['middleware' => ['providerCheckPermission']], function () {

            Route::get('home', 'SiteController@home')->name('home');
            Route::get('notifications', 'SiteController@notifications')->name('notifications');
            Route::post('/search'                               , 'SiteController@search')->name('search');

            Route::group(['prefix' => 'medicine', 'as' => 'medicine.'], function () {
                Route::get('/', 'MedicineController@index')->name('index');
                Route::get('create', 'MedicineController@create')->name('create');
                Route::post('create', 'MedicineController@store')->name('store');
                Route::get('{medicine_id}/edit', 'MedicineController@edit')->name('edit');
                Route::put('{medicine_id}', 'MedicineController@update')->name('update');
                Route::delete('{medicine_id}', 'MedicineController@delete')->name('delete');
            });

            Route::group(['prefix' => 'reservations', 'as' => 'reservations.'], function () {
                Route::put('patient-enter/{reservation_id}', 'ReservationController@patientEnter')->name('patientEnter');
                Route::put('refuse', 'ReservationController@refuse')->name('refuse');
                Route::put('accept/{reservation_id}', 'ReservationController@accept')->name('accept');
                Route::get('/new', 'ReservationController@newReservations')->name('new');
                Route::get('/accepted', 'ReservationController@acceptedReservations')->name('accepted');

                // doctor reservations labs section
                Route::get('/{reservation_id}/detais', 'ReservationController@reservationDetails')->name('details');
                Route::get('/{reservation_id}/choose-lab', 'ReservationController@chooseLab')->name('chooseLab');
                Route::get('/{reservation_id}/lab-reservation', 'ReservationController@labReservation')->name('labReservation');
                Route::post('/send-patient-to-lab', 'ReservationController@sendPatientToLab')->name('sendPatientToLab');
                Route::post('/add-prescription-form', 'ReservationController@addPrescriptionForm')->name('addPrescriptionForm');
                Route::post('/write-prescription', 'ReservationController@writePrescription')->name('writePrescription');
            });

            Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
                Route::get('/finished', 'ReportController@finished')->name('finished');
                Route::get('/canceled', 'ReportController@canceled')->name('canceled');
                Route::get('/{id}/reservation-details', 'ReportController@reservationDetails')->name('reservationDetails');
                Route::get('/income', 'ReportController@income')->name('income');
            });

            Route::group(['prefix' => 'rules', 'as' => 'rules.'], function () {
                Route::get('/', 'RuleController@index')->name('index');
                Route::get('/add', 'RuleController@add')->name('add');
                Route::post('/store', 'RuleController@store')->name('store');
                Route::put('/change-password', 'RuleController@changePassword')->name('changePassword');
                Route::delete('/delete/{id}', 'RuleController@delete')->name('delete');
            });

            Route::group(['prefix' => 'opinions', 'as' => 'opinions.'], function () {
                Route::get('/', 'OpinionController@index')->name('index');
                Route::post('/report', 'OpinionController@report')->name('report');
            });

            Route::group(['prefix' => 'suggestions', 'as' => 'suggestions.'], function () {
                Route::get('/', 'SuggestionController@index')->name('index');
                Route::post('/send', 'SuggestionController@send')->name('send');
            });

        });



    });

});
