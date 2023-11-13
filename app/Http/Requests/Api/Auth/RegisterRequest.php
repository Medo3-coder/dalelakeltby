<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Api\BaseApiRequest;

class RegisterRequest extends BaseApiRequest
{

  public function __construct(Request $request)
  {
    $request['phone']        = fixPhone($request['phone']);
    $request['country_code'] = fixPhone($request['country_code']);
  }

  public function rules()
  {
    return [
      'name'                   => 'required|max:50',
      'country_code'           => 'required|numeric|digits_between:2,5',
      'phone'                  => 'required|numeric|digits_between:9,10|unique:users,phone,NULL,id,deleted_at,NULL',
      'blood_type_id'          => 'required|exists:blood_types,id',
      'age'                    => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
      'weight'                 => 'required|numeric|digits_between:2,3',
      'height'                 => 'required|numeric|digits_between:2,3',
      'gender'                 => 'required|in:male,female',
      'have_chranic_disease'   => 'required',
      'chranic_disease_ids'    => 'nullable|array',
      'password'               => 'required|min:6|max:20',
      'image'                  => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    ];
  }
}
