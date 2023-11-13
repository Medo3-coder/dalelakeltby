<?php

namespace App\Http\Requests\Admin\labs;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                  => 'required|max:191',
            'lab_name'                  => 'required|max:191',
            'identity_image'        => 'required|image|mimes:jpeg,png,jpg,gif',
            'image'                 => 'required|image|mimes:jpeg,png,jpg,gif',
            'phone'                 => 'required|digits_between:9,11|unique:labs,phone',
            "country_code"                        => "required",
            'identity_id'            => 'required|numeric|min:10',
            'email'                 => 'required|email|max:191|unique:labs,email',
            'password'              => ['required','max:191'],
            'block'                 => 'required',

            'price'               => 'nullable',  
            'sonar_types'           => 'nullable',  
            // 'target_body_ids'            => 'nullable',
            'type'                => 'nullable',
        ];
    }

}
