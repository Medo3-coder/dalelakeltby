<?php

namespace App\Http\Requests\Lab\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LabActivateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'country_code'  => 'required' ,
            'phone'         => 'required|exists:users,phone' ,
            'code'          => 'required' ,
        ];
    }
}
