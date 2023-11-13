<?php

namespace App\Http\Requests\Doctor\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'id'                    => 'required',
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
