<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;

class addLocationRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'title'   => 'nullable' ,
            'lat'     => 'required' , 
            'lng'     => 'required' ,
            'address' => 'required' , 
        ];
    }
}
