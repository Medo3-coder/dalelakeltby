<?php

namespace App\Http\Requests\Doctor\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'country_code' => 'required',
            'phone'        => 'required|min:8|exists:doctors,phone',
            'password'     => 'required|min:6',
        ];
    }

    public function prepareForValidation() {
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code),
        ]);
    }
}
