<?php

namespace App\Http\Requests\Pharmacy\Suggestion;

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
