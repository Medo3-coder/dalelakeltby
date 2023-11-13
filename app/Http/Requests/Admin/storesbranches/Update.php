<?php

namespace App\Http\Requests\Admin\storesbranches;

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
            'address'                                 => 'required',
            "comerical_record"                        => "required",
            'lat'                                     => 'required',
            'opening_certificate_pdf'                 => 'nullable|mimes:pdf|max:10000',
            'opening_certificate_image'               => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'lng'                                     => 'nullable',
            "images"                              => 'nullable',

            "store_id"                                  => "nullable",
            "days"                                    => 'nullable',
            "from"                                    => "nullable",
            "to"                                      => 'nullable',
        ];
    }
}
