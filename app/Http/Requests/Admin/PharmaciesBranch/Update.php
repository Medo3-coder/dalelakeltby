<?php

namespace App\Http\Requests\Admin\PharmaciesBranch;

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
            'name'                                  => 'required|max:191',
            'address'                               => 'required',
            "comerical_record"                      => "required",
            'lat'                                   => 'nullable',
            'lng'                                   => 'nullable',
            "pharmacist_id"                         => "nullable",
            "days"                              => 'nullable',
            "images"                          => "nullable",
            "from"                          => "nullable",
            "to"                             => 'nullable',
        ];
    }
}
