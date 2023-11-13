<?php

namespace App\Http\Requests\Admin\fqs;

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
            'question.ar'                => 'required',
            'question.en'                => 'required',
            'question.kur'                => 'required',
            'answer.ar'                  => 'required',
            'answer.en'                  => 'required',
            'answer.kur'                  => 'required',
        ];;
    }
}
