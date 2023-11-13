<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\BaseApiRequest;

class ResendCodeRequest extends BaseApiRequest {
  public function __construct(Request $request) {
    $request['phone']        = fixPhone($request['phone']);
    $request['country_code'] = fixPhone($request['country_code']);
  }

  public function rules() {
    return [
      'country_code' => 'required',
      'phone'        => 'required|exists:users,phone',
    ];
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      if (!User::where('phone', $this->phone)->where('country_code', $this->country_code)->first()) {
        $validator->errors()->add('phone', trans('auth.failed'));
      }
    });
  }
}
