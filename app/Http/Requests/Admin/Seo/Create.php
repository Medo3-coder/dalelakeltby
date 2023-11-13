<?php

namespace App\Http\Requests\Admin\Seo;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         return [
            'key'                           => 'required',

            'meta_title.kur'                 => 'required',
            'meta_title.en'                 => 'required',
            'meta_title.ar'                 => 'required',

            'meta_description.kur'           => 'required',
            'meta_description.ar'           => 'required',
            'meta_description.en'           => 'required',

            'meta_keywords.kur'              => 'required',
            'meta_keywords.ar'              => 'required',
            'meta_keywords.en'              => 'required',
        ];
    }
    public function messages()
    {
        return [
            'key.required'                  => 'ال key مطلوب',
        ];
    }
}
