<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Auth\ForgetPasswordRequest;
use App\Http\Requests\Store\Auth\LoginRequest;
use App\Http\Requests\Store\Auth\RegisterRequest;
use App\Http\Requests\Store\Auth\StoreActivateRequest;
use App\Models\Country;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function chooseLogin()
    {
        return view('providers_dashboards.store.auth.choose_login');
    }

    public function showLogin()
    {
        $countries = Country::get();
        return view('providers_dashboards.store.auth.login', compact('countries'));
    }


    public function showLoginEmployees()
    {
        $countries = Country::get();
        return view('providers_dashboards.store.auth.loginEmployees', compact('countries'));
    }

    public function register()
    {
        $countries = Country::get();
        return view('providers_dashboards.store.auth.register', compact('countries'));

    }

    public function attempt($attemptArray)
    {
        return $attempt = Auth::guard('store')->attempt($attemptArray);
    }

    public function checkTimes($request, $index)
    {
        $timesArray = $request['times'];
        $check = 'true';
        for ($i = 0; $i <= $index; $i++){
            if ($timesArray['days-' . $i]) {

                $array = $timesArray['days-' . $i];

                $unique = array_unique($array);

                $times = [];

                foreach ($unique as $value){
                    $duplicated = array_keys(array_intersect($array, $unique), $value);
                    $from = array_values(array_intersect_key($timesArray['from-'. $i], array_flip($duplicated)));
                    $to = array_values(array_intersect_key($timesArray['to-' . $i], array_flip($duplicated)));
                    $times[] = [$value=>['from'=>$from, 'to'=>$to]];

                }


                foreach ($times as  $values){
                    foreach ($values as $value){


                        $count = count($value['from']);
                        for ($i = 0; $i < $count; $i++) {

                            if ($value['from'][$i] && $value['to'][$i]) {
                                $start = Carbon::createFromTimeString($value['from'][$i]);
                                $end = Carbon::createFromTimeString($value['to'][$i]);


                                for ($i2 = 0; $i2 < $count; $i2++) {
                                    if ($i2 != $i) {

                                        $previos_from = Carbon::createFromTimeString($value['from'][$i2]);
                                        $previos_to = Carbon::createFromTimeString($value['to'][$i2]);

                                        if ($start->between($previos_from, $previos_to) || $end->between($previos_from, $previos_to, false)) {
                                            $check = 'false';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $check;
    }

    public function registerStore(RegisterRequest $request)
    {
        $index = $request['index'];

        if ($this->checkTimes($request, $index) == 'false'){
            $msg = __('store.Error in working hours');
            return response()->json(['key'=>'fail', 'msg'=>$msg]);
        }

        $requestStore   = $request->only(['image', 'name', 'phone', 'email', 'identity_number', 'country_code', 'identity_image', 'password', 'delivery_price']);

        $store          = Store::create($requestStore);

        for ($i = 0; $i <= $index; $i++){

            $name                           = $request['name-' . $i];
            $lat                            = $request['lat-' . $i];
            $lng                            = $request['lng-' . $i];
            $address                        = $request['address-' . $i];
            $addressMap                     = $request['address_map-' . $i];
            $opening_certificate_image      = $request['opening_certificate_image-' . $i];
            $opening_certificate_pdf        = $request['opening_certificate_pdf-' . $i];
            $comerical_record               = $request['comerical_record-' . $i];

            $branch = $store->branches()->create([
                'name'                          =>  $name,
                'lat'                           =>  $lat,
                'lng'                           =>  $lng,
                'address'                       =>  $address,
                'address_map'                   =>  $addressMap,
                'opening_certificate_image'     =>  $opening_certificate_image,
                'opening_certificate_pdf'       =>  $opening_certificate_pdf,
                'comerical_record'              =>  $comerical_record

            ]);

            foreach ($request['times']['days-' . $i] as $key => $value){

                $branch->dates()->create([
                    'store_id'              =>  $store['id'],
                    'day'                   =>  $value,
                    'from'                  =>  $request['times']['from-' . $i][$key],
                    'to'                    =>  $request['times']['to-' . $i][$key]
                ]);

            }


            foreach ($request['images-' . $i] as $image){
                $branch->images()->create(['store_id'=>$store['id'], 'image'=>$image]);
            }

        }

        $msg = __('store.Congratulations!') . ' ' . __('store.Your account has been created successfully');

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.activatePage', ['phone'=>$store['phone'], 'country_code'=>$store['country_code']])]);

    }

    public function login(LoginRequest $request)
    {
        $attemptArray = [
            'country_code'  =>  $request['country_code'] ,
            'phone'         =>  $request['phone'] ,
            'password'      =>  $request['password'],
            'parent_id'     =>  null
        ];

        $attempt = Auth::guard('store')->attempt($attemptArray);

        if (!$attempt){
            return response()->json(['status' => 'password_fail'    ,'input' => 'password', 'msg' => __('auth.failed')]);
        }

        $store = Auth::guard('store')->user();

        if ($store['is_blocked'] == 1){
            return response()->json(['status' => 'blocked'         , 'msg' => __('site.blocked')]);
        }

        if ($store['is_active'] == 0){
            return response()->json(['status' => 'need_active'     , 'msg' => __('site.need_active'), 'url' => route('store.activatePage' , ['country_code' => $request['country_code'] , 'phone' => $request['phone']])]);
        }

        if ($store['is_approved'] != 'accepted'){
            return response()->json(['status' => 'is_approved_fail' , 'msg' => $store['is_approved'] == 'pending' ? __('site.wait_accept') : __('site.refused')]);
        }

        return response()->json(['status' => 'success' ,'url' => route('store.home') , 'msg' => __('site.logined')] );
    }

    public function loginEmployees(LoginRequest $request)
    {
        $attemptArray = [
            'country_code'  =>  $request['country_code'] ,
            'phone'         =>  $request['phone'] ,
            'password'      =>  $request['password'],
        ];


        $attempt = $this->attempt($attemptArray);

        if (!$attempt){
            return response()->json(['status' => 'password_fail'    ,'input' => 'password', 'msg' => __('auth.failed')]);
        }

        $store = Auth::guard('store')->user();

        if ($store['parent_id'] == null){
            return response()->json(['status' => 'password_fail'    ,'input' => 'password', 'msg' => __('auth.failed')]);
        }

        if ($store['is_blocked'] == 1){
            return response()->json(['status' => 'blocked'         , 'msg' => __('site.blocked')]);
        }

        if ($store['is_active'] == 0){
            return response()->json(['status' => 'need_active'     , 'msg' => __('site.need_active'), 'url' => route('store.activatePage' , ['country_code' => $request['country_code'] , 'phone' => $request['phone']])]);
        }

        if ($store['is_approved'] != 'accepted'){
            return response()->json(['status' => 'is_approved_fail' , 'msg' => $store['is_approved'] == 'pending' ? __('site.wait_accept') : __('site.refused')]);
        }

        return response()->json(['status' => 'success' ,'url' => route('store.home') , 'msg' => __('site.logined')] );
    }


    public function activatePage($country_code ,$phone)
    {
        $store = Store::where(['country_code' => $country_code, 'phone' => $phone])->firstOrFail();
        $store->sendVerificationCode();

        return view('providers_dashboards.store.auth.activate', compact('phone', 'country_code'));
    }

    public function activate(StoreActivateRequest $request)
    {
        $store = Store::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();

        if ($store->code != $request->code) {
            return response()->json(['status' => 'fail', 'msg' => __('site.check_code') , 'input' => 'code']);
        }

        Session::forget(['phone', 'country_code']);

        $store->update(['is_active'=>1]);

        return response()->json(['status' => 'success' , 'url'  => route('store.login') , 'msg' => __('site.user_activated')]) ;
        
    }

    public function forgetPasswordShow()
    {
        $countries = Country::get();
        return view('providers_dashboards.store.auth.forget-password', compact('countries'));
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $store = Store::where(['country_code'=>$request['country_code'], 'phone'=>$request['phone']])->firstOrFail();
        $store->sendVerificationCode();
        Session::put(['country_code'=>$store['country_code'], 'phone'=>$store['phone']]);
        return response()->json(['status'=>'success', 'url'=>route('store.activeCodeForgetPasswordShow'), 'msg'=>__('auth.send_activated')]);
    }

    public function resetCode(Request $request)
    {
        $store = Store::where(['country_code'=>$request['country_code'], 'phone'=>$request['phone']])->firstOrFail();
        $store->sendVerificationCode();
        return response()->json(['status'=>'success',  'msg'=>__('auth.resend_activated')]);

    }

    public function activeCodeForgetPasswordShow()
    {
        if (!Session::has('phone') && !Session::has('country_code')){
            return redirect()->route('store.showLogin');
        }
        $store = Store::where(['country_code'=>Session::get('country_code'), 'phone'=>Session::get('phone')])->firstOrFail();
        return view('providers_dashboards.store.auth.activeCodeForgetPassword', compact('store'));
    }



    public function logout()
    {
        Auth::guard('store')->logout();

        return redirect()->route('store.login')->with(['success'=>__('store.logout')]);
    }

}
