<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Suggestion\SendRequest as SuggestionSendRequest;

class SuggestionController extends Controller {

    public function index() {
        return view('providers_dashboards.pharmacy.suggestions.index');
    }

    public function send(SuggestionSendRequest $request) {
        provider('pharmacy')->suggestions()->create($request->validated());
        return response()->json(['status' => 'success', 'msg' => __('apis.messageSended'), 'url' => route('pharmacy.home')]);
    }
}
