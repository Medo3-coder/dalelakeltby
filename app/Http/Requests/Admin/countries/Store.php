<?php

namespace App\Http\Requests\Admin\countries;

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
            'name.ar'                => 'required|max:191',
            'name.en'                => 'required|max:191',
            'name.kur'               => 'required|max:191',
            'image'                  => 'required|image|mimes:jpeg,png,jpg,gif',
            'key'                    => 'required|unique:countries,key',
        ];
       
    }
}
