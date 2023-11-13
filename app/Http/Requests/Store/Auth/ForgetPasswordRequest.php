<?php

namespace App\Http\Requests\Store\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'country_code'  => 'required' ,
            'phone'         => 'required|digits_between:9,10|exists:stores,phone' ,
        ];
    }

    public function prepareForValidation()
    {
        $phone = fixPhone($this->phone);
        $this->merge([
            'phone' => $phone ,
        ]);
    }
}
