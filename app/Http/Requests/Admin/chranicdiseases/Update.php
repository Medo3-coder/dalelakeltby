<?php

namespace App\Http\Requests\Admin\chranicdiseases;

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
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
