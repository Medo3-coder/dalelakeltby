<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Rule\ChangePassword;
use App\Http\Requests\Pharmacy\Rule\Create;
use App\Models\Country;
use App\Models\Pharmacist;
use App\Models\ProviderRule;
use App\Services\ProviderRuleService;

class RuleController extends Controller {

    public function index() {
        if (request()->ajax()) {
            $rules = Pharmacist::where('parent_id', provider('pharmacy')->id)->orderBy('updated_at')->paginate(30);
            $html  = view('providers_dashboards.pharmacy.rules.table', compact('rules'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.rules.index');
    }

    public function add() {
        $permissions = ProviderRuleService::getCreateProviderPermissions('pharmacy');
        $countries   = Country::get();
        return view('providers_dashboards.pharmacy.rules.add', compact('permissions', 'countries'));
    }

    public function store(Create $request) {
        $pharmascist = Pharmacist::create($request->validated());
        $permissions = [];
        foreach ($request->validated()['permissions'] as $permission) {
            $permissions[] = new ProviderRule(['permission' => $permission]);
        }
        $pharmascist->roles()->saveMany($permissions);

        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.added'),
            'url'    => route('pharmacy.rules.index'),
        ]);
    }

    public function changePassword(ChangePassword $request) {
        provider('pharmacy')->children()->findOrFail($request->id)->update([
            'password' => $request->password,
        ]);
        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.updated'),
        ]);
    }

    public function delete($id) {
        provider('pharmacy')->children()->findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

}
