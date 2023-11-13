<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\analysistypes\Store;
use App\Http\Requests\Store\Rule\ChangePassword;
use App\Http\Requests\Store\Rule\Create;
use App\Models\Country;
use App\Models\ProviderRule;
use App\Services\ProviderRuleService;
use Illuminate\Support\Facades\Route;

class RuleController extends Controller {

    public function index() {

        if (request()->ajax()) {
            $store = authUser('store');
            $rules = $store->employees()->orderBy('updated_at')->paginate(30);
            $html  = view('providers_dashboards.store.rules.table', compact('rules'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.store.rules.index');
    }

    public function add() {
        $permissions = ProviderRuleService::getCreateProviderPermissions('store');
        $countries   = Country::get();
        return view('providers_dashboards.store.rules.add', compact('permissions', 'countries'));
    }

    public function store(Create $request) {
        $store = authUser('store');
        $provider = $store->create($request->validated());

        $permissions = [];
        foreach ($request->validated()['permissions'] as $permission) {
            $permissions[] = new ProviderRule(['permission' => $permission]);
        }
        $provider->roles()->saveMany($permissions);

        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.added'),
            'url'    => route('store.rules.index'),
        ]);
    }

    public function changePassword(ChangePassword $request) {
        provider('store')->employees()->findOrFail($request->id)->update([
            'password' => $request->password,
        ]);
        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.updated'),
        ]);
    }

    public function delete($id) {
        provider('store')->employees()->findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

}
