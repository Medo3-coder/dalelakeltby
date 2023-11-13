<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Auth\ActivateRequest;
use App\Http\Requests\Pharmacy\Auth\ForgetPasswordCheckCodeRequest;
use App\Http\Requests\Pharmacy\Auth\ForgetPasswordResetRequest;
use App\Http\Requests\Pharmacy\Auth\ForgetPasswordSendCodeRequest;
use App\Http\Requests\Pharmacy\Auth\LoginRequest;
use App\Http\Requests\Pharmacy\Auth\RegisterRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Country;
use App\Models\Pharmacist;
use App\Models\PharmacyBranchImage;
use App\Notifications\NewPharmasistRegestrationNotification;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller {
    use ResponseTrait;

    public function chooseLogin() {
        return redirect()->route('pharmacy.login');
        return view('providers_dashboards.pharmacy.auth.chose-login');
    }

    public function showLogin() {
        $countries = Country::get();
        return view('providers_dashboards.pharmacy.auth.login', compact('countries'));
    }

    public function login(LoginRequest $request) {
        if (!$pharmacy = auth()->guard('pharmacy')->attempt([
            'country_code' => $request->country_code, 'phone' => $request->phone, 'password' => $request->password,
            'is_approved'  => 'accepted', 'is_active'         => 1, 'is_blocked'             => 0,
        ])) {

            $pharmacy = Pharmacist::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();

            if (!$pharmacy) {
                return response()->json(['status' => 'country_code_fail', 'input' => 'country_code', 'msg' => __('site.check_country_code')]);
            } elseif ($pharmacy->is_blocked == 1) {
                return response()->json(['status' => 'blocked', 'msg' => __('site.blocked')]);
            } elseif ($pharmacy->is_active == 0) {
                return response()->json(['status' => 'need_active', 'msg' => __('site.need_active'), 'url' => route('doctor.activate', ['country_code' => $request->country_code, 'phone' => $request->phone])]);} elseif ($pharmacy->is_approved != 'accepted') {
                return response()->json(['status' => 'is_approved_fail', 'msg' => $pharmacy->is_approved == 'pending' ? __('site.wait_accept') : __('site.refused')]);
            } else {
                return response()->json(['status' => 'password_fail', 'input' => 'password', 'msg' => __('site.check_your_password')]);
            }
        }

        return response()->json(['status' => 'success', 'url' => route('pharmacy.home'), 'msg' => __('site.logined')]);

    }

    public function logout() {
        auth('pharmacy')->user()->logout();
        return redirect()->route('pharmacy.site');
    }

    public function register() {
        $countries  = Country::get();
        $categories = Category::where(['type' => 'doctor', 'parent_id' => null])->get();
        return view('providers_dashboards.pharmacy.auth.register.index', get_defined_vars());
    }

    public function getSubSpecialities($id) {
        $subspecialities = Category::findOrFail($id)->childes;
        return response()->json(['html' => view('providers_dashboards.pharmacy.auth.register.includes.html.register.sub_speciality_select', compact('subspecialities'))->render()]);
    }

    public function postRegister(RegisterRequest $request) {
        DB::beginTransaction();
        try {
            $pharmacist = Pharmacist::create($request->validated());

            foreach ($request->validated()['branches'] as $branch) {
                $newBranch = $pharmacist->branches()->create($branch);

                foreach ($branch['dates'] as $date) {
                    $newBranch->dates()->create($date);
                }

                $images = [];
                foreach ($branch['images'] as $image) {
                    $images[] = new PharmacyBranchImage(['image' => $image]);
                }
                $newBranch->images()->saveMany($images);
            }

            // notify admins new doctor regester to approve or reject
            Notification::send(Admin::get(), new NewPharmasistRegestrationNotification($pharmacist->id, route('admin.pharmacies.pending')));

            $pharmacist->sendPhoneActivationCode();

            DB::commit();

            return response()->json([
                'status' => 'success', 'url' => route('pharmacy.activate', ['phone' => $pharmacist['phone'], 'country_code' => $pharmacist['country_code']]),
                'msg'    => __('apis.accoun_created'),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            info('pharmacist auth controller postRegister function  error : ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'msg' => __('admin.unknown_error')]);
        }
    }

    public function activate() {
        return view('providers_dashboards.pharmacy.auth.activate');
    }

    public function resendCode(Request $request) {
        $pharmacist = Pharmacist::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        $pharmacist->sendPhoneActivationCode();
        return response()->json(['msg' => __('admin.send_successfully')]);
    }

    public function postActivate(ActivateRequest $request) {
        $pharmacist = Pharmacist::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        if ($request->code != $pharmacist->code) {
            return response()->json(['status' => 'fail', 'msg' => __('apis.not_correct_code')]);
        }
        $pharmacist->update([
            'is_active' => 1,
            'code'      => null,
        ]);
        return response()->json(['status' => 'success', 'msg' => __('apis.activated'), 'url' => route('pharmacy.login')]);
    }

    public function forgetPassword() {
        $countries = Country::get();
        return view('providers_dashboards.pharmacy.auth.forget_password', compact('countries'));
    }

    public function forgetPasswordSendCode(ForgetPasswordSendCodeRequest $request) {
        $pharmacist = Pharmacist::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        $pharmacist->sendPhoneActivationCode();
        return response()->json(['status' => 'success', 'url' => route('pharmacy.forgetPasswordCheckCode', $request->validated()), 'msg' => __('auth.send_activated')]);
    }

    public function forgetPasswordCheckCode() {
        return view('providers_dashboards.pharmacy.auth.forget_password_check_code');
    }

    public function postForgetPasswordCheckCode(ForgetPasswordCheckCodeRequest $request) {
        $pharmacist = Pharmacist::where(['country_code' => $request->country_code, 'phone' => $request->phone])->firstOrFail();
        if ($request->code != $pharmacist->code) {
            return response()->json(['status' => 'fail', 'msg' => __('apis.not_correct_code')]);
        }
        if (session()->has('resePassword')) {
            session()->remove('resePassword');
        }
        session()->put('resePassword', $request->validated());
        return response()->json(['status' => 'success', 'url' => route('pharmacy.forgetPasswordReset'), 'msg' => __('localize.resetpassword')]);
    }

    public function forgetPasswordReset() {
        return view('providers_dashboards.pharmacy.auth.forget_password_reset');
    }

    public function postForgetPasswordReset(ForgetPasswordResetRequest $request) {
        $pharmacist = Pharmacist::where(session()->get('resePassword'))->firstOrfail();
        $pharmacist->update($request->validated() + (['code' => null]));
        return response()->json(['status' => 'success', 'msg' => __('apis.password_cahnged'), 'url' => route('pharmacy.login')]);
    }

}
