<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\Suggestion\SendRequest;

class SuggestionController extends Controller {

    public function index() {
        return view('providers_dashboards.lab.suggestions.index');
    }

    public function send(SendRequest $request) {
        provider('lab')->suggestions()->create($request->validated());
        return response()->json(['status' => 'success', 'msg' => __('apis.messageSended'), 'url' => route('lab.home')]);
    }
}
