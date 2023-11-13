<?php

namespace App\Http\Requests\Admin\clinicsbranch;

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
            "detection_price"                      => 'required',
            "record_number"                      => "required",
            'lat'                                   => 'required',
            'lng'                                   => 'required',
            "clinic_id"                         => "nullable",
            "doctor_id"                         => "nullable",
            "days"                              => 'nullable',
            "from"                          => "nullable",
            "to"                             => 'nullable',
            'images'                         => "nullable",

        ];
    }
}
