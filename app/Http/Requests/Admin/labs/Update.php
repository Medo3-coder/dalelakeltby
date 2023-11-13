<?php

namespace App\Http\Requests\Admin\labs;

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
            'identity_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'phone'                 => 'nullable|numeric|unique:labs,phone,'.$this->id,
            'email'                 => 'nullable|email|max:191|unique:labs,email,'.$this->id,
            "country_code"                        => "required",
            'identity_id'            => 'nullable|numeric|min:10',
            'password'              => ['nullable','max:191'],
        ];
    }
}
