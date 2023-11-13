<?php

namespace App\Http\Requests\Admin\Pharmacies;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                                => 'required|max:191',
            'phone'                               => 'required|digits_between:9,11|unique:pharmacists,phone',
            'image'                               => 'required|image|mimes:jpeg,png,jpg,gif',
            'graduation_certification_image'      => 'required|image|mimes:jpeg,png,jpg,gif',
            'practice_certification_image'        => 'required|image|mimes:jpeg,png,jpg,gif',
            'experience_certification_image'      => 'required|image|mimes:jpeg,png,jpg,gif',
            'experience_years'                    => 'required|numeric',
            "country_code"                        => "required",
            "identity_number"                     => 'required|numeric|min:10',
            'identity_image'                      => 'required|image|mimes:jpeg,png,jpg,gif',
            'graduation_certification_pdf'        => 'required|mimes:pdf|max:10000',
            'practice_certification_pdf'          => 'required|mimes:pdf|max:10000',
            'experience_certification_pdf'        => 'required|mimes:pdf|max:10000',
            'email'                               => 'required|email|max:191|unique:pharmacists,email',
            'password'                            => ['required', 'max:191'],
            'block'                                => 'nullable',
            "age"                                  => "required|numeric",
        ];
    }
}
