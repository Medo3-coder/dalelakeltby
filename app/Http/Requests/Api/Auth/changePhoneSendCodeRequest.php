<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\BaseApiRequest;

class changePhoneSendCodeRequest extends BaseApiRequest
{
    public function __construct(Request $request) {
        $request['phone']        = fixPhone($request['phone']);
        $request['country_code'] = fixPhone($request['country_code']);
    }

    public function rules() {
        return [
            'country_code' => 'required|exists:users,country_code',
            'phone'        => 'required|unique:users,phone',
            'password'     => 'required|min:6',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('password') && !Hash::check($this->password, auth()->user()->password)) {
                $validator->errors()->add('password', trans('auth.incorrect_pass'));
            }
        });
    }
}
