<?php

namespace App\Http\Requests\Pharmacy\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordCheckCodeRequest extends FormRequest {
    public function rules() {
        return [
            'country_code' => 'required',
            'phone'        => 'required',
            'code'         => 'required|min:6',
        ];
    }

    public function prepareForValidation() {
        $phone = fixPhone($this->phone);
        $this->merge([
            'phone' => $phone,
        ]);
    }
}
