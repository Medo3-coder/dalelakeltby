<?php

namespace App\Http\Requests\Lab\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ActivateRequest extends FormRequest {
    public function rules() {
        return [
            'country_code' => 'required',
            'phone'        => 'required|digits_between:8,12',
            'code'         => 'required',
        ];
    }

    public function prepareForValidation() {
        $phone = fixPhone($this->phone);
        $this->merge([
            'phone' => $phone,
        ]);
    }
}
