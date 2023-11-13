<?php

namespace App\Http\Requests\Admin\intros;

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
            'title.kur'                  => 'required',
            'title.ar'                  => 'required',
            'title.en'                  => 'required',
            'description.kur'            => 'required',
            'description.ar'            => 'required',
            'description.en'            => 'required',
            'image'                     => ['required','image'],
        ];
    }
}
