<?php

namespace App\Http\Requests\Admin\clinicsbranch;

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
            "detection_price"                      => 'required',
            "record_number"                      => "required",
            'lat'                                   => 'required',
            'lng'                                   => 'required',
            "doctor_id"                         => "nullable",
            "days"                              => 'required',
            "from"                          => "required",
            "to"                             => 'nullable',
            'images'                         =>'nullable' ,
            "clinic_id"                       => "nullable"
        ];
    }
}
