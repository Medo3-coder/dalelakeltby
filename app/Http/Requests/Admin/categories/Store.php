<?php

namespace App\Http\Requests\Admin\categories;

use Illuminate\Foundation\Http\FormRequest;

class store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name.kur'                  => 'required|max:191',
            'name.ar'                  => 'required|max:191',
            'name.en'                  => 'required|max:191',
            'parent_id'                => 'nullable|exists:categories,id',
            'image'                    => ['nullable','image'],
        ];
    }
}
