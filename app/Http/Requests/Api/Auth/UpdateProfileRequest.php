<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Http\Request;

class UpdateProfileRequest extends BaseApiRequest {

  public function rules() {
    return [
      'name'                   => 'sometimes|required',
      'email'                  => 'sometimes|required|e mail|max:50|unique:users,email,' . auth()->id(),
      'image'                  => 'sometimes|nullable|image',
      'blood_type_id'          => 'sometimes|required|exists:blood_types,id',
      'age'                    => 'sometimes|required|digits:4|integer|min:1900|max:'   . (date('Y') + 1),
      'weight'                 => 'sometimes|required|numeric|digits_between:2,3',
      'height'                 => 'sometimes|required|numeric|digits_between:2,3',
      // 'have_chranic_disease'   => 'required',
      // 'chranic_disease_ids'    => 'nullable',
      // 'gender'                 => 'required|in:male,female',
    ];
  }

  public function withValidator($validator) {
    $validator->after(function ($validator) {
      // if ($this->has('old_password') && !Hash::check($this->old_password, auth()->user()->password)) {
      //   $validator->errors()->add('old_password', trans('auth.incorrect_old_pass'));
      // }
    });
  }

}
