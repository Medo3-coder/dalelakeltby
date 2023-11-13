<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Requests\Api\BaseApiRequest;

class ActivateRequest extends BaseApiRequest {
  use GeneralTrait ; 
  public function __construct(Request $request) {
    $request['phone']        = fixPhone($request['phone']);
    $request['country_code'] = fixPhone($request['country_code']);
  }

  public function rules() {
    return [
      'code'         => 'required|max:10',
      'country_code' => 'required|exists:users,country_code',
      'phone'        => 'required|exists:users,phone',
      'device_id'    => 'required|max:250',
      'device_type'  => 'in:ios,android,web',
      'lang'         => 'required',
    ];
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      if (!$user = User::where('phone', $this->phone)->where('country_code', $this->country_code)->first()) {
        $validator->errors()->add('phone', trans('auth.failed'));
      }
      if (!$this->isCodeCorrect($user, $this->code)) {
        $validator->errors()->add('code', trans('auth.code_invalid'));
      }
    });
  }
}
