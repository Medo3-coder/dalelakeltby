<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Rule\ChangePassword;
use App\Http\Requests\Doctor\Rule\Create;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\ProviderRule;
use App\Services\ProviderRuleService;

class RuleController extends Controller {

    public function index() {
        if (request()->ajax()) {
            $rules = Doctor::where('parent_id', provider('doctor')->id)->orderBy('updated_at')->paginate(30);
            $html  = view('providers_dashboards.doctor.rules.table', compact('rules'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.doctor.rules.index');
    }

    public function add() {
        // $rules     = ProviderRule::where('type', 'doctor')->get();
        $permissions = ProviderRuleService::getCreateProviderPermissions('doctor');
        $countries   = Country::get();
        return view('providers_dashboards.doctor.rules.add', compact('permissions', 'countries'));
    }

    public function store(Create $request) {
        $doctor      = Doctor::create($request->validated());
        $permissions = [];
        foreach ($request->validated()['permissions'] as $permission) {
            $permissions[] = new ProviderRule(['permission' => $permission]);
        }
        $doctor->roles()->saveMany($permissions);

        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.added'),
            'url'    => route('doctor.rules.index'),
        ]);
    }

    public function changePassword(ChangePassword $request) {
        provider('doctor')->children()->findOrFail($request->id)->update([
            'password' => $request->password,
        ]);
        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.updated'),
        ]);
    }

    public function delete($id) {
        provider('doctor')->children()->findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

}
