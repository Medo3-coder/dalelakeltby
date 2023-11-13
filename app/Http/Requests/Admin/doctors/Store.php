<?php

namespace App\Http\Requests\Admin\doctors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Store extends FormRequest
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
            'name'                                => 'required|max:191',
            'nickname'                            => 'required|max:191',
            'image'                               => 'required|image|mimes:jpeg,png,jpg,gif',
            'graduation_certification_image'      => 'required|image|mimes:jpeg,png,jpg,gif',
            'practice_certification_image'        => 'required|image|mimes:jpeg,png,jpg,gif',
            'experience_certification_image'      => 'required|image|mimes:jpeg,png,jpg,gif',
            'identity_image'                      => 'required|image|mimes:jpeg,png,jpg,gif',
            'graduation_certification_pdf'        => 'nullable|mimes:pdf|max:10000',
            'practice_certification_pdf'          => 'nullable|mimes:pdf|max:10000',
            'experience_certification_pdf'        => 'nullable|mimes:pdf|max:10000',
            'experience_years'                    => 'required|numeric',
            'phone'                               => 'required|digits_between:9,11|unique:doctors,phone',
            'email'                               => 'required|email|max:191|unique:doctors,email',
            "country_code"                        => "required",
            "identity_number"                      =>  'required|numeric',
            'examination_price'                   => 'required|numeric',
            'age'                                 => 'required|numeric',
            'specialty_id'                        => 'required',
            'block'                               => 'nullable',
            'password'                            => ['required', 'max:191'],
        ];
    }
}
