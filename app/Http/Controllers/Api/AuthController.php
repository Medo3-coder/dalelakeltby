<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\SmsTrait;
use App\Models\Complaint;
use App\Models\UserUpdate;
use App\Models\UserLocation;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ActivateRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\UpdateLocationRequest;
use App\Http\Requests\Api\Auth\ResendCodeRequest;
use App\Http\Requests\Api\User\addLocationRequest;
use App\Http\Requests\Api\Auth\UpdateProfileRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\StoreComplaintRequest;
use App\Http\Requests\Api\Auth\UpdatePasswordRequest;
use App\Http\Requests\Api\Auth\changePhoneSendCodeRequest;
use App\Http\Requests\Api\User\changePhoneCheckCodeRequest;
use App\Http\Resources\Api\UserLocation as ApiUserLocation;
use App\Http\Requests\Api\Auth\forgetPasswordSendCodeRequest;
use App\Http\Resources\Api\Notifications\NotificationsCollection;

class AuthController extends Controller {
  use ResponseTrait, SmsTrait, GeneralTrait;

  public function register(RegisterRequest $request) {
    $user = User::create($request->validated());
    $user->diseases()->attach($request['chranic_disease_ids']);
    $user->sendVerificationCode();
    return $this->response('success', __('auth.registered'), ['user' => new UserResource($user->refresh())]);
  }

  public function activate(ActivateRequest $request) {
    return $this->response('success', __('auth.activated'), [
      'user' => User::where('phone', $request['phone'])->where('country_code', $request['country_code'])->first()->markAsActive()->login()
    ]);
  }

  public function resendCode(ResendCodeRequest $request) {
    User::where('phone', $request['phone'])->where('country_code', $request['country_code'])->first()->sendVerificationCode();
    return $this->response('success', __('auth.code_re_send'));
  }

  public function login(LoginRequest $request) {
    $user = User::where('phone', $request->phone)->where('country_code', $request->country_code)->first() ;
    if (!Hash::check($request->password, $user->password)) {
      return $this->failMsg(__('auth.incorrect_pass'));
    }
    if ($user->is_blocked) {
      return $this->blockedReturn($user);
    }
    if (!$user->active) {
      return $this->phoneActivationReturn($user);
    }

    return $this->response('success', __('apis.signed'), $user->login());
  }

  public function logout(Request $request) {
    if ($request->bearerToken()) {
      $user = Auth::guard('sanctum')->user();
      if ($user) {
        $user->logout();
      }
    }
    return $this->response('success', __('apis.loggedOut'));
  }

  public function getProfile(Request $request) {
    return $this->successData(UserResource::make(auth()->user())->setToken(ltrim($request->header('authorization'), 'Bearer ')));
  }

  public function updateProfile(UpdateProfileRequest $request) {
    auth()->user()->update($request->validated());
    return $this->response('success', __('apis.updated'), UserResource::make(auth()->user()->refresh())->setToken(ltrim($request->header('authorization'), 'Bearer ')));
  }

  public function updatePassword(UpdatePasswordRequest $request) {
    $user = auth()->user();
    $user->update($request->validated());
    return $this->successMsg(__('apis.updated'));
  }

  public function forgetPasswordSendCode(forgetPasswordSendCodeRequest $request) {
    if(!$user = User::where('phone', $request['phone'])
                    ->where('country_code', $request['country_code'])
                    ->first()){
      
      return $this->failMsg(__('auth.failed'));
    }
    if (!$user) {
      return $this->failMsg(trans('site.user_wrong'));
    }
    UserUpdate::updateOrCreate(['user_id' => $user->id , 'type' => 'password' ] , ['code' => ''] );
    return $this->successMsg();
  }

  public function forgetCheckCode(Request $request)
  {
      if(!$user = User::where('phone', $request['phone'])
          ->where('country_code', $request['country_code'])
          ->first()){

          return $this->failMsg(__('auth.failed'));
      }

      if (!$this->isCodeCorrect($user, $request->code)) {
          return $this->failMsg(trans('auth.code_invalid'));
      }
      return $this->successMsg(trans('auth.correct_code'));
  }


  public function resetPassword(ForgetPasswordRequest $request) {
    if(!$user = User::where('phone', $request['phone'])
                    ->where('country_code', $request['country_code'])
                    ->first()){
      
      return $this->failMsg(__('auth.failed'));
    }

    // $update = UserUpdate::where(['user_id' => $user->id , 'type' => 'password' , 'code' => $request->code])->first() ;
    // if (!$update) {
    //   return $this->failMsg(trans('auth.code_invalid'));
    // }

    if (!$this->isCodeCorrect($user, $request->code)) {
      return $this->failMsg(trans('auth.code_invalid'));
    }

    $user->update(['password' => $request->password, 'code' => null, 'code_expire' => null]);
    return $this->successMsg(trans('auth.password_changed'));
  }

  public function changeLang(Request $request) {
    $user = auth()->user();
    $lang = in_array($request->lang, languages()) ? $request->lang : 'ar';
    $user->update(['lang' => $lang]);
    App::setLocale($lang);
    return $this->successMsg(__('apis.updated'));
  }

  public function switchNotificationStatus() {
    $user = auth()->user();
    $user->update(['is_notify' => !$user->is_notify]);
    return $this->response('success', __('apis.updated'), ['notify' => (bool) $user->refresh()->is_notify]);
  }

  public function getNotifications() {
    auth()->user()->unreadNotifications->markAsRead();
    $notifications = new NotificationsCollection(auth()->user()->notifications()->paginate($this->paginateNum()));
    return $this->successData(['notifications' => $notifications]);
  }

  public function countUnreadNotifications() {
    return $this->successData(['count' => auth()->user()->unreadNotifications->count()]);
  }

  public function deleteNotification($notification_id) {
    auth()->user()->notifications()->where('id', $notification_id)->delete();
    return $this->successMsg( __('site.notify_deleted'));
  }
  
  public function deleteNotifications() {
    auth()->user()->notifications()->delete();
    return $this->successMsg( __('apis.deleted'));
  }

  public function StoreComplaint(StoreComplaintRequest $Request) {
    Complaint::create($Request->validated() + (['user_id' => auth()->id()]));
    return $this->successMsg( __('apis.complaint_send'));
  }


  
  public function changePhoneSendCode(changePhoneSendCodeRequest $request) {
    UserUpdate::updateOrCreate([
      'user_id'       => auth()->id() ,
      'type'          => 'phone',
      'country_code'  => $request->country_code ,
      'phone'         => $request->phone 
    ] , [
      'code' => 1234
    ] );
    return $this->successMsg(trans('auth.send_activated'));
  }
  public function changePhoneCheckCode(changePhoneCheckCodeRequest $request) {
    $update = UserUpdate::where(['user_id' => auth()->id() ,'type' => 'phone' ,'code' => $request->code])->first();
    if (!$update) {
      return $this->failMsg(trans('auth.code_invalid'));
    }
    auth()->user()->update(['phone' => $update->phone , 'country_code' => $update->country_code]) ;
    $update->delete();
    return $this->successMsg(__('apis.updated'));
  }
  public function deleteAccount(){
    // if there any delete conditions write it here 
    auth()->user()->delete() ;
    return $this->successMsg( __('auth.account_deleted'));
  }

  public function userLocations()
  {
    return $this->successData(['locations' => ApiUserLocation::collection(UserLocation::where(['user_id' => auth()->id()])->latest()->get())]);
  }


  public function addLocation(addLocationRequest $request)
  {
    UserLocation::create($request->validated() + ['user_id' => auth()->id()]);
    return $this->successMsg(__('apis.locations_added'));
  }


  public function deleteLocation($location_id)
  {
    UserLocation::findOrFail($location_id)->delete();
    return $this->successMsg(__('apis.locations_deleted'));
  }


  public function updateLocation(addLocationRequest $request , $location_id)
  {
    UserLocation::findOrFail($location_id)->update($request->validated());
    return $this->successMsg(__('apis.locations_updated'));
  }
}
