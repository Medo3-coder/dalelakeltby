<?php

namespace App\Http\Requests\Admin\LabBranch;

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
            'address'                               => 'required',
            "comerical_record"                      => "required",
            'lat'                                   => 'required',
            'opening_certificate_pdf'                => 'required|mimes:pdf|max:10000',
            'opening_certificate_image'            => 'required|image|mimes:jpeg,png,jpg,gif',
            'lng'                                   => 'required',
            "lab_id"                         => "required",
            "days"                              => 'required',
            "from"                          => "required",
            "to"                             => 'required',
            
        ];
    }
}
