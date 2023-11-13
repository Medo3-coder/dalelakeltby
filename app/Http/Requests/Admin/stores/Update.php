<?php

namespace App\Http\Requests\Admin\stores;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                  => 'required|max:191',
            'phone'                 => 'required|numeric|unique:stores,phone',
            'email'                 => 'required|email|max:191|unique:stores,email',
            'password'              => ['required', 'max:191'],
            'identity_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_blocked'            => 'nullable',
        ];
    }
}
