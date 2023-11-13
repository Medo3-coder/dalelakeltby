<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\Auth\ActivateRequest;
use App\Http\Requests\Lab\Auth\ForgetPasswordCheckCodeRequest;
use App\Http\Requests\Lab\Auth\ForgetPasswordResetRequest;
use App\Http\Requests\Lab\Auth\ForgetPasswordSendCodeRequest;
use App\Http\Requests\Lab\Auth\LoginRequest;
use App\Http\Requests\Lab\Auth\RegisterRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Lab;
use App\Models\LabBranchImage;
use App\Notifications\NewLabRegestrationNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller {
    public function chooseLogin() {
        return view('providers_dashboards.lab.auth.choose_login');
    }

    public function showLogin() {
        $countries = Country::get();
        return view('providers_dashboards.lab.auth.login', compact('countries'));
    }

    public function showLoginEmployees()
    {
        $countries = Country::get();
        return view('providers_dashboards.lab.auth.loginEmployees', compact('countries'));
    }

    public function attempt($attemptArray)
    {
        return $attempt = Auth::guard('lab')->attempt($attemptArray);
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

        $lab = Auth::guard('lab')->user();

        if ($lab['parent_id'] == null){
            $lab->logout();
            return response()->json(['status' => 'password_fail'    ,'input' => 'password', 'msg' => __('auth.failed')]);
        }

        if ($lab['is_blocked'] == 1){
            $lab->logout();
            return response()->json(['status' => 'blocked'         , 'msg' => __('site.blocked')]);
        }

        if ($lab['is_active'] == 0){
            $lab->logout();
            return response()->json(['status' => 'need_active'     , 'msg' => __('site.need_active'), 'url' => route('lab.activatePage' , ['country_code' => $request['country_code'] , 'phone' => $request['phone']])]);
        }

        if ($lab['is_approved'] != 'accepted'){
            $lab->logout();
            return response()->json(['status' => 'is_approved_fail' , 'msg' => $lab['is_approved'] == 'pending' ? __('site.wait_accept') : __('site.refused')]);
        }

        return response()->json(['status' => 'success' ,'url' => route('lab.home') , 'msg' => __('site.logined')] );
    }


    public function login(LoginRequest $request) {
        if (!$lab = auth()->guard('lab')->attempt([
            'country_code' => $request->country_code, 'phone' => $request->phone, 'password' => $request->password,
            'is_approved'  => 'accepted', 'is_active'         => 1, 'is_blocked'             => 0,
        ])) {

            $lab = Lab::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();

            if (!$lab) {
                return response()->json(['status' => 'country_code_fail', 'input' => 'country_code', 'msg' => __('site.check_country_code')]);
            } elseif ($lab->is_blocked == 1) {
                return response()->json(['status' => 'blocked', 'msg' => __('site.blocked')]);
            } elseif ($lab->is_active == 0) {
                return response()->json(['status' => 'need_active', 'msg' => __('site.need_active'), 'url' => route('lab.activate', ['country_code' => $request->country_code, 'phone' => $request->phone])]);} elseif ($lab->is_approved != 'accepted') {
                return response()->json(['status' => 'is_approved_fail', 'msg' => $lab->is_approved == 'pending' ? __('site.wait_accept') : __('site.refused')]);
            } else {
                return response()->json(['status' => 'password_fail', 'input' => 'password', 'msg' => __('site.check_your_password')]);
            }
        }

        return response()->json(['status' => 'success', 'url' => route('lab.home'), 'msg' => __('site.logined')]);

    }

    public function register() {
        $countries  = Country::get();
        $cities     = City::where('country_id', 1)->get();
        $categories = Category::where(['type' => 'lab', 'parent_id' => null])->get();
        return view('providers_dashboards.lab.auth.register.index', get_defined_vars());
    }

    public function postRegister(RegisterRequest $request) {

        // dd($request->all());

        DB::beginTransaction();
        try {
            $lab = Lab::create($request->validated());

            foreach ($request->validated()['branches'] as $branch) {
                $newBranch = $lab->branches()->create($branch);

                foreach ($branch['dates'] as $date) {
                    $newBranch->dates()->create($date);
                }

                $images = [];
                foreach ($branch['images'] as $image) {
                    $images[] = new LabBranchImage(['image' => $image]);
                }
                $newBranch->images()->saveMany($images);
            }

            $lab->labCategories()->attach($request->validated()['category_ids']);

            // add the sub categories of the lab
            foreach ($request->validated()['labCategories'] as $typeCategories) {
                foreach ($typeCategories as $subCategory) {
                    $labSubCategory = $lab->labSubCategoriesHasMany()->create($subCategory);
                    if (isset($subCategory['targeted_bodies'])) {
                        $labSubCategory->targetedBodyAreas()->attach($subCategory['targeted_bodies']);
                    }
                }
            } // end add lab categories

            // notify admins new doctor regester to approve or reject
            Notification::send(Admin::get(), new NewLabRegestrationNotification($lab->id, route('admin.labs.pending')));

            $lab->sendPhoneActivationCode();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'url'    => route('lab.activate', ['phone' => $lab['phone'], 'country_code' => $lab['country_code']]),
                'msg'    => __('apis.accoun_created'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            info('lab auth controller postRegister function  error : ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'msg' => __('admin.unknown_error')]);
        }
    }

    public function activate() {
        return view('providers_dashboards.lab.auth.activate');
    }

    public function resendCode(Request $request) {
        $lab = Lab::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        $lab->sendPhoneActivationCode();
        return response()->json(['msg' => __('admin.send_successfully')]);
    }

    public function postActivate(ActivateRequest $request) {
        $lab = Lab::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        if ($request->code != $lab->code) {
            return response()->json(['status' => 'fail', 'msg' => __('apis.not_correct_code')]);
        }
        $lab->update([
            'is_active' => 1,
            'code'      => null,
        ]);
        return response()->json(['status' => 'success', 'msg' => __('apis.activated'), 'url' => route('lab.showLogin')]);
    }

    public function forgetPassword() {
        $countries = Country::get();
        return view('providers_dashboards.lab.auth.forget_password', compact('countries'));
    }

    public function forgetPasswordSendCode(ForgetPasswordSendCodeRequest $request) {
        $lab = Lab::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();
        if (!$lab) {
            return response()->json([
                'status' => 'fail',
                'msg'    => __('apis.not_found'),
            ]);
        }
        $lab->sendPhoneActivationCode();
        return response()->json(['status' => 'success', 'url' => route('lab.forgetPasswordCheckCode', $request->validated()), 'msg' => __('auth.send_activated')]);
    }

    public function forgetPasswordCheckCode() {
        return view('providers_dashboards.lab.auth.forget_password_check_code');
    }

    public function postForgetPasswordCheckCode(ForgetPasswordCheckCodeRequest $request) {
        $lab = Lab::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        if ($request->code != $lab->code) {
            return response()->json(['status' => 'fail', 'msg' => __('apis.not_correct_code')]);
        }
        if (session()->has('resePassword')) {
            session()->remove('resePassword');
        }
        session()->put('resePassword', $request->validated());
        return response()->json(['status' => 'success', 'url' => route('lab.forgetPasswordReset'), 'msg' => __('localize.resetpassword')]);
    }

    public function forgetPasswordReset() {
        return view('providers_dashboards.lab.auth.forget_password_reset');
    }

    public function postForgetPasswordReset(ForgetPasswordResetRequest $request) {
        $lab = Lab::where(session()->get('resePassword'))->firstOrfail();
        $lab->update($request->validated() + (['code' => null]));
        return response()->json(['status' => 'success', 'msg' => __('apis.password_cahnged'), 'url' => route('lab.showLogin')]);
    }

    public function logout() {
        auth('lab')->user()->logout();
        return redirect()->route('lab.site');
    }

}
