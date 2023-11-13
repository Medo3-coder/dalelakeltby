<?php

namespace App\Http\Requests\Doctor\Suggestion;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'message' => 'required',
        ];
    }
}
