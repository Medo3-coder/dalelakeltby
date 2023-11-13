<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Auth\ActivateRequest;
use App\Http\Requests\Doctor\Auth\ForgetPasswordCheckCodeRequest;
use App\Http\Requests\Doctor\Auth\ForgetPasswordResetRequest;
use App\Http\Requests\Doctor\Auth\ForgetPasswordSendCodeRequest;
use App\Http\Requests\Doctor\Auth\LoginRequest;
use App\Http\Requests\Doctor\Auth\RegisterRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Models\ClinicImages;
use App\Models\Country;
use App\Models\Doctor;
use App\Notifications\NewDoctorRegestrationNotification;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller {
    use ResponseTrait;

    public function chooseLogin() {
        return view('providers_dashboards.doctor.auth.chose-login');
    }

    public function showLogin() {
        $countries = Country::get();
        return view('providers_dashboards.doctor.auth.login', compact('countries'));
    }

    public function login(LoginRequest $request) {
        if (!$doctor = auth()->guard('doctor')->attempt([
            'country_code' => $request->country_code, 'phone' => $request->phone, 'password' => $request->password,
            'is_approved'  => 'accepted', 'is_active'         => 1, 'is_blocked'             => 0,
        ])) {

            $doctor = Doctor::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();

            if (!$doctor) {
                return response()->json(['status' => 'country_code_fail', 'input' => 'country_code', 'msg' => __('site.check_country_code')]);
            } elseif ($doctor->is_blocked == 1) {
                return response()->json(['status' => 'blocked', 'msg' => __('site.blocked')]);
            } elseif ($doctor->is_active == 0) {
                return response()->json(['status' => 'need_active', 'msg' => __('site.need_active'), 'url' => route('doctor.activate', ['country_code' => $request->country_code, 'phone' => $request->phone])]);} elseif ($doctor->is_approved != 'accepted') {
                return response()->json(['status' => 'is_approved_fail', 'msg' => $doctor->is_approved == 'pending' ? __('site.wait_accept') : __('site.refused')]);
            } else {
                return response()->json(['status' => 'password_fail', 'input' => 'password', 'msg' => __('site.check_your_password')]);
            }
        }

        return response()->json(['status' => 'success', 'url' => route('doctor.home'), 'msg' => __('site.logined')]);

    }

    public function logout() {
        auth('doctor')->user()->logout();
        return redirect()->route('doctor.site');
    }

    public function register() {
        $countries  = Country::get();
        $cities     = City::where('country_id', 1)->get();
        $categories = Category::where(['type' => 'doctor', 'parent_id' => null])->get();
        return view('providers_dashboards.doctor.auth.register.index', get_defined_vars());
    }

    public function getSubSpecialities($id) {
        $subspecialities = Category::findOrFail($id)->childes;
        return response()->json(['html' => view('providers_dashboards.doctor.auth.register.includes.html.register.sub_speciality_select', compact('subspecialities'))->render()]);
    }

    public function postRegister(RegisterRequest $request) {
        DB::beginTransaction();
        try {
            $doctor = Doctor::create($request->validated());

            foreach ($request->validated()['clinics'] as $clinic) {
                $newClinic = $doctor->clinics()->create($clinic);

                foreach ($clinic['dates'] as $date) {
                    $newClinic->dates()->create($date);
                }

                $images = [];
                foreach ($clinic['images'] as $image) {
                    $images[] = new ClinicImages(['image' => $image]);
                }
                $newClinic->images()->saveMany($images);
            }

            // notify admins new doctor regester to approve or reject
            Notification::send(Admin::get(), new NewDoctorRegestrationNotification($doctor->id, route('admin.doctors.pending')));

            $doctor->sendPhoneActivationCode();

            DB::commit();

            return response()->json([
                'status' => 'success', 'url' => route('doctor.activate', ['phone' => $doctor['phone'], 'country_code' => $doctor['country_code']]),
                'msg'    => __('apis.accoun_created'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            info('doctor auth controller postRegister function  error : ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'msg' => __('admin.unknown_error')]);
        }
    }

    public function activate() {
        return view('providers_dashboards.doctor.auth.activate');
    }

    public function resendCode(Request $request) {
        $doctor = Doctor::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        $doctor->sendPhoneActivationCode();
        return response()->json(['msg' => __('admin.send_successfully')]);
    }

    public function postActivate(ActivateRequest $request) {
        $doctor = Doctor::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        if ($request->code != $doctor->code) {
            return response()->json(['status' => 'fail', 'msg' => __('apis.not_correct_code')]);
        }
        $doctor->update([
            'is_active' => 1,
            'code'      => null,
        ]);
        return response()->json(['status' => 'success', 'msg' => __('apis.activated'), 'url' => route('doctor.login')]);
    }

    public function forgetPassword() {
        $countries = Country::get();
        return view('providers_dashboards.doctor.auth.forget_password', compact('countries'));
    }

    public function forgetPasswordSendCode(ForgetPasswordSendCodeRequest $request) {
        $doctor = Doctor::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        $doctor->sendPhoneActivationCode();
        return response()->json(['status' => 'success', 'url' => route('doctor.forgetPasswordCheckCode', $request->validated()), 'msg' => __('auth.send_activated')]);
    }

    public function forgetPasswordCheckCode() {
        return view('providers_dashboards.doctor.auth.forget_password_check_code');
    }

    public function postForgetPasswordCheckCode(ForgetPasswordCheckCodeRequest $request) {
        $doctor = Doctor::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        if ($request->code != $doctor->code) {
            return response()->json(['status' => 'fail', 'msg' => __('apis.not_correct_code')]);
        }
        if (session()->has('resePassword')) {
            session()->remove('resePassword');
        }
        session()->put('resePassword', $request->validated());
        return response()->json(['status' => 'success', 'url' => route('doctor.forgetPasswordReset'), 'msg' => __('localize.resetpassword')]);
    }

    public function forgetPasswordReset() {
        return view('providers_dashboards.doctor.auth.forget_password_reset');
    }

    public function postForgetPasswordReset(ForgetPasswordResetRequest $request) {
        $doctor = Doctor::where(session()->get('resePassword'))->firstOrfail();
        $doctor->update($request->validated() + (['code' => null]));
        return response()->json(['status' => 'success', 'msg' => __('apis.password_cahnged'), 'url' => route('doctor.login')]);
    }

}
