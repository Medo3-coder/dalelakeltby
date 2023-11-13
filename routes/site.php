<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'HtmlMinifier']], function () {

    /* ################## start redirect index */
    Route::get('/', 'IntroController@index')->name('intro');
    Route::get('/privacy-policy', 'IntroController@privacyPolicy')->name('IntroPrivacyPolicy');
    Route::post('/send-message', 'IntroController@sendMessage');
    /* ################## end redirect index */

    // guest routes
    Route::group(['middleware' => ['guest']], function () {

    });
    // guest routes

    // auth  routes
    Route::group(['middleware' => ['auth']], function () {

    });
    // auth  routes

    Route::get('/lang/{lang}', 'SiteController@SetLanguage')->name('lang');

    // chat example
    // TODO: move this into the auth middleware group
    Route::get('/show-chat/{id}', 'ChatController@getChatRoom')->name('getChatRoom');
    Route::post('/upload-chat-file', 'ChatController@uploadChatFile')->name('uploadChatFile');

});
