<?php

namespace App\Http\Requests\Admin\PharmaciesBranch;

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
            'name'                                  => 'required|max:191',
            'address'                               => 'required',
            "comerical_record"                      => "required",
            'lat'                                   => 'required',
            'lng'                                   => 'required',
            "pharmacist_id"                         => "required",
            "days"                              => 'required',
            "from"                          => "required",
            "to"                             => 'required',
            'images'                         => 'required',
            
        ];
    }
}
