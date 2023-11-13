<?php

namespace App\Http\Requests\Admin\doctors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Update extends FormRequest
{
    public function __construct(Request $request)
    {
        $request['phone']        = fixPhone($request['phone']);
    }
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                  => 'required|max:191',
            "nickname"              => "nullable|max:191",
            'phone'                 => 'required|numeric|unique:doctors,phone,' . $this->id,
            'email'                 => 'required|email|max:191|unique:doctors,email,' . $this->id,
            'examination_price'     => 'nullable|numeric',
            'specialty_id'          => 'nullable',
            "identity_number"            => 'nullable|numeric',
            "age"                    =>  'nullable|numeric',
            "country_code"                        => "nullable",
            'experience_years'                    => 'nullable|numeric',

            'image'                               => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'identity_image'                      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'graduation_certification_pdf'        => 'nullable|mimes:pdf|max:10000',
            'practice_certification_pdf'          => 'nullable|mimes:pdf|max:10000',
            'experience_certification_pdf'        => 'nullable|mimes:pdf|max:10000',
            'graduation_certification_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'practice_certification_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'experience_certification_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'password'              => ['nullable', 'max:191'],
            "is_blocked"                              => "required",

        ];
    }
}
