<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\Rule\ChangePassword;
use App\Http\Requests\Lab\Rule\Create;
use App\Models\Country;
use App\Models\Lab;
use App\Models\ProviderRule;
use App\Services\ProviderRuleService;

class RuleController extends Controller {

    public function index() {
        if (request()->ajax()) {
            $rules = Lab::where('parent_id', provider('lab')->id)->orderBy('updated_at')->paginate(30);
            $html  = view('providers_dashboards.lab.rules.table', compact('rules'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.lab.rules.index');
    }

    public function add() {
        $permissions = ProviderRuleService::getCreateProviderPermissions('lab');
        $countries   = Country::get();
        return view('providers_dashboards.lab.rules.add', compact('permissions', 'countries'));
    }

    public function store(Create $request) {
        $provider    = Lab::create($request->validated());
        $permissions = [];
        foreach ($request->validated()['permissions'] as $permission) {
            $permissions[] = new ProviderRule(['permission' => $permission]);
        }
        $provider->roles()->saveMany($permissions);

        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.added'),
            'url'    => route('lab.rules.index'),
        ]);
    }

    public function changePassword(ChangePassword $request) {
        provider('lab')->children()->findOrFail($request->id)->update([
            'password' => $request->password,
        ]);
        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.updated'),
        ]);
    }

    public function delete($id) {
        provider('lab')->children()->findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

}
