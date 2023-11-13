<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Rule\Create;
use App\Http\Requests\Doctor\Suggestion\SendRequest;

class SuggestionController extends Controller {

    public function index() {
        return view('providers_dashboards.doctor.suggestions.index');
    }

    public function send(SendRequest $request) {
        provider('doctor')->suggestions()->create($request->validated());
        return response()->json(['status' => 'success', 'msg' => __('apis.messageSended'), 'url' => route('doctor.home')]);
    }
}
