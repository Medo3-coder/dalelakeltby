<?php

namespace App\Http\Requests\Admin\LabBranch;

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
            'address'                               => 'required',
            "comerical_record"                      => "required",
            'lat'                                   => 'required',
            'opening_certificate_pdf'                => 'nullable|mimes:pdf|max:10000',
            'opening_certificate_image'            => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'lng'                                   => 'nullable',
            "lab_id"                         => "nullable",
            'images'                          => 'nullable',
            "days"                              => 'nullable',
            "from"                          => "nullable",
            "to"                             => 'nullable',
        ];
    }
}
