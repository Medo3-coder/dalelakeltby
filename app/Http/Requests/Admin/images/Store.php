<?php

namespace App\Http\Requests\Admin\images;

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
            'image'                => ['required','image'],
        ];
    }
}
