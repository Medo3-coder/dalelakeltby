<?php

namespace App\Http\Requests\Api\Reservation;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RateReservationRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'id'        => 'required|exists:reservations,id' ,
            'rate'      => 'required|numeric|min:1|max:5'            ,
            'comment'   => 'required'                 ,
        ];
    }
}
