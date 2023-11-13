<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LabController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\UserController;

Route::group([
    'namespace'  => 'Api',
    'middleware' => ['api-cors', 'api-lang'],
], function () {

    Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {
        /***************************** SettingController start *****************************/
            Route::get('about'                       ,[SettingController::class, 'about']);
            Route::get('terms'                       ,[SettingController::class, 'terms']);
            Route::get('privacy'                     ,[SettingController::class, 'privacy']);
            Route::get('intros'                      ,[SettingController::class, 'intros']);
            Route::get('fqss'                        ,[SettingController::class, 'fqss']);
            Route::get('socials'                     ,[SettingController::class, 'socials']);
            Route::get('images'                      ,[SettingController::class, 'images']);
            Route::get('categories/{id?}'            ,[SettingController::class, 'categories']);
            Route::get('countries'                   ,[SettingController::class, 'countries']);
            Route::get('countries-with-cities'       ,[SettingController::class, 'countriesWithCities']);
            Route::get('specialities-and-cities'     ,[SettingController::class, 'specialitiesAndCities']);
            Route::get('cities'                      ,[SettingController::class, 'cities']);
            Route::get('country/{country_id}/cities' ,[SettingController::class, 'CountryCities']);
            Route::post('check-coupon'               ,[SettingController::class, 'checkCoupon']);
            Route::get('is-production'               ,[SettingController::class, 'isProduction']);
            Route::post('contact'                    ,[SettingController::class, 'contact']);
            
            
            Route::get('how-work'                    ,[SettingController::class , 'howWork']);
            Route::get('blood-types'                 ,[SettingController::class , 'bloodtypes']);
            Route::get('diseases'                    ,[SettingController::class , 'diseases']);
            Route::get('specialties'                 ,[SettingController::class , 'specialties']);
            Route::get('medical-advices'             ,[SettingController::class , 'medicalAdvices']);
            Route::get('providers-links'             ,[SettingController::class , 'providersLinks']);
            Route::get('medical-advice-details/{id}' ,[SettingController::class , 'medicalAdviceDetails']);
        /***************************** SettingController End *****************************/

        /***************************** HomeController start *****************************/
            Route::get('home'                         , [HomeController::class, 'home']);
        /***************************** HomeController End *****************************/


        /***************************** DoctorController start *****************************/
            Route::post('doctor-filter'               , [DoctorController::class, 'doctorFilter']);
            Route::get('doctor-details/{id}'          , [DoctorController::class, 'doctorDetails']);
            Route::get('doctor-details/{id}/comments' , [DoctorController::class, 'comments']);
            Route::post('comments/{id}/add-complaint' , [DoctorController::class, 'addComplaint']);
        /***************************** DoctorController End *****************************/

        /***************************** DoctorController start *****************************/
            Route::post('filter-labs'                 , [LabController::class, 'labFilter']);
            Route::get('lab-details/{id}'             , [LabController::class, 'labDetails']);
            Route::post('lab-category-details'        , [LabController::class, 'labCategoryDetails']);
            Route::post('add-lab-reservations-data'   , [LabController::class, 'addLabReservationsData']);
        /***************************** DoctorController End *****************************/
    });

    Route::group(['middleware' => ['guest']], function () {
        /***************************** SettingController  Start *****************************/
            Route::get('register-data'                 ,[SettingController::class, 'registerData']);
        /***************************** SettingController  Start *****************************/

        /***************************** AuthController  Start *****************************/
            Route::post('sign-up'                      ,[AuthController::class, 'register']);
            Route::patch('activate'                    ,[AuthController::class, 'activate']);
            Route::get('resend-code'                   ,[AuthController::class, 'resendCode']);
            Route::post('sign-in'                      ,[AuthController::class, 'login']);
            Route::delete('sign-out'                   ,[AuthController::class, 'logout']);
            Route::post('forget-password-send-code'    ,[AuthController::class, 'forgetPasswordSendCode']);
            Route::post('forget-check-code'            ,[AuthController::class, 'forgetCheckCode']);
            Route::post('reset-password'               ,[AuthController::class, 'resetPassword']);
        /***************************** AuthController  Start *****************************/
    });

    Route::group(['middleware' => ['auth:sanctum', 'is-active']], function () {
        
        /***************************** AuthController  Start *****************************/
            Route::get('profile'                                  ,[AuthController::class,       'getProfile']);
            Route::put('update-profile'                           ,[AuthController::class,       'updateProfile']);
            Route::patch('update-passward'                        ,[AuthController::class,       'updatePassword']);
            Route::put('update-location'                          ,[AuthController::class,       'updateLocation']);
            Route::patch('change-lang'                            ,[AuthController::class,       'changeLang']);
            Route::patch('switch-notify'                          ,[AuthController::class,       'switchNotificationStatus']);
            Route::post('change-phone-send-code'                  ,[AuthController::class,       'changePhoneSendCode']);
            Route::post('change-phone-check-code'                 ,[AuthController::class,       'changePhoneCheckCode']);
            Route::post('change-email-send-code'                  ,[AuthController::class,       'changeEmailSendCode']);
            Route::post('change-email-check-code'                 ,[AuthController::class,       'changeEmailCheckCode']);
            Route::get('notifications'                            ,[AuthController::class,       'getNotifications']);
            Route::get('count-notifications'                      ,[AuthController::class,       'countUnreadNotifications']);
            Route::delete('delete-notification/{notification_id}' ,[AuthController::class,       'deleteNotification']);
            Route::delete('delete-notifications'                  ,[AuthController::class,       'deleteNotifications']);
            Route::post('new-complaint'                           ,[AuthController::class,       'StoreComplaint']);
            Route::delete('delete-account'                        ,[AuthController::class,       'deleteAccount']);
            Route::get('user-locations'                           ,[AuthController::class,       'userLocations']);
            Route::post('add-location'                            ,[AuthController::class,       'addLocation']);
            Route::delete('delete-location/{id}'                  ,[AuthController::class,       'deleteLocation']);
            Route::patch('update-location/{id}'                   ,[AuthController::class,       'updateLocation']);
        /***************************** AuthController end *****************************/

        /***************************** ReservationController start *****************************/
            Route::post('send-reservation'                         , [ReservationController::class, 'sendReservation']);
            Route::get('new-reservations'                          , [ReservationController::class, 'newReservations']);
            Route::get('cancel-reasons'                            , [ReservationController::class, 'cancelReasons']);
            Route::get('approved-reservations'                     , [ReservationController::class, 'approvedReservations']);
            Route::get('finished-reservations'                     , [ReservationController::class, 'finishedReservations']);
            Route::get('reservation-details/{id}'                  , [ReservationController::class, 'reservationDetails']);
            Route::post('cancel-reservation'                       , [ReservationController::class, 'cancelReservation']);
            Route::post('rate-reservation'                         , [ReservationController::class, 'rateReservation']);
        /***************************** ReservationController End *****************************/
        
        /***************************** MedicalRecordController end *****************************/
            Route::get('/personal-record'                           , [MedicalRecordController::class ,'personalRecord']);
            Route::get('/family-record'                             , [MedicalRecordController::class ,'familyRecord']);
            Route::get('/medical-record-details/{reservation_id}'   , [MedicalRecordController::class ,'medicalRecordDetails']);
            Route::post('/start-use-receipt/{reservation_id}'       , [MedicalRecordController::class ,'startUseReceipt']);
            Route::post('/the-medicine-has-been-taken/{medicine_id}', [MedicalRecordController::class ,'theMedicineHasBeenTaken']);
            /***************************** MedicalRecordController end *****************************/
            
            /***************************** UserController start *****************************/
            Route::get('/wallet'                                , [UserController::class ,'wallet']);
            Route::post('/charge-wallet'                        , [UserController::class ,'chargeWallet']);
        /***************************** UserController end *****************************/

        /***************************** ChatController start *****************************/
            Route::get('create-room'                       ,[ChatController::class, 'createRoom']);
            Route::post('create-private-room'              ,[ChatController::class, 'createPrivateRoom']);
            Route::get('room-members/{room}'               ,[ChatController::class, 'getRoomMembers']);
            Route::get('join-room/{room}'                  ,[ChatController::class, 'joinRoom']);
            Route::get('leave-room/{room}'                 ,[ChatController::class, 'leaveRoom']);
            Route::get('get-room-messages/{room}'          ,[ChatController::class, 'getRoomMessages']);
            Route::get('get-room-unseen-messages/{room}'   ,[ChatController::class, 'getRoomUnseenMessages']);
            Route::get('get-rooms'                         ,[ChatController::class, 'getMyRooms']);
            Route::delete('delete-message-copy/{message}'  ,[ChatController::class, 'deleteMessageCopy']);
            Route::post('send-message/{room}'              ,[ChatController::class, 'sendMessage']);
            Route::post('upload-room-file/{room}'          ,[ChatController::class, 'uploadRoomFile']);
        /***************************** ChatController end *****************************/

    });


});
