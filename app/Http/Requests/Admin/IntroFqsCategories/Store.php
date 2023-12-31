<?php

namespace App\Http\Requests\Admin\IntroFqsCategories;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'title.ar' => 'required' ,
            'title.en' => 'required' ,
            'title.kur' => 'required' ,
        ];
    }
}
