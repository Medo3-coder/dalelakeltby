<?php

namespace App\Http\Requests\Admin\stores;

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
            'store_name'            => 'required|max:191',
            'phone'                 => 'required|digits_between:9,11|unique:stores,phone',
            'email'                 => 'required|email|max:191|unique:stores,email',
            'password'              => ['required', 'max:191'],
            'identity_image'        => 'required|image|mimes:jpeg,png,jpg,gif',
            'image'                 => 'required|image|mimes:jpeg,png,jpg,gif',
            'identity_number'       => 'required|numeric|min:10',
            'is_blocked'            => 'nullable',
        ];
    }
}
