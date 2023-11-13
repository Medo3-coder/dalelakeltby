<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Suggestion\SendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function auth()
    {
        return provider('store');
    }

    public function index() {
        return view('providers_dashboards.store.suggestions.index');
    }

    public function send(SendRequest $request) {
        $store = $this->auth();
        $store->suggestions()->create($request->validated());
        return response()->json(['status' => 'success', 'msg' => __('apis.messageSended'), 'url' => route('store.home')]);
    }
}
