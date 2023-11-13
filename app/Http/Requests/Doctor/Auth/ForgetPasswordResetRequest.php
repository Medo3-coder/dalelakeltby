<?php

namespace App\Http\Requests\Doctor\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordResetRequest extends FormRequest {
    public function rules() {
        return [
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
