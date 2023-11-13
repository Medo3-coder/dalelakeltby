<?php

namespace App\Http\Requests\Admin\Pharmacies;

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
            'phone'                 => 'required|numeric|unique:pharmacists,phone,' . $this->id,
            'email'                 => 'required|email|max:191|unique:pharmacists,email,' . $this->id,
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'experience_years'                    => 'nullable|numeric',
            "identity_number"            => 'nullable|numeric',
            "age"                    =>  'nullable|numeric',
            "country_code"                        => "required",
            'graduation_certification_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'practice_certification_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'experience_certification_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'graduation_certification_pdf'        => 'nullable|mimes:pdf|max:10000',
            'practice_certification_pdf'          => 'nullable|mimes:pdf|max:10000',
            'experience_certification_pdf'        => 'nullable|mimes:pdf|max:10000',
            'identity_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'password'              => ['nullable', 'max:191'],
        ];
    }
}
