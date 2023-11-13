<?php

namespace App\Http\Requests\Pharmacy\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordSendCodeRequest extends FormRequest {
    public function rules() {
        return [
            'country_code' => 'required',
            'phone'        => 'required',
        ];
    }

    public function prepareForValidation() {
        $phone = fixPhone($this->phone);
        $this->merge([
            'phone' => $phone,
        ]);
    }
}
