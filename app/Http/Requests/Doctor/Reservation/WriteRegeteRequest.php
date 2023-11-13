<?php

namespace App\Http\Requests\Doctor\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class WriteRegeteRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function __construct() {
        request()['doctor_id'] = provider('doctor')->id;
    }

    public function rules() {
        return [
            'reservation_id'     => 'required|exists:reservations,id',
            'diagnosis'          => 'required',
            'medicines'          => 'required|array',
            'medicines.*'        => 'required|exists:doctor_medicines,id',
            'hours'              => 'required',
            'hours.*'            => 'required|numeric',
            'times'              => 'required',
            'times.*'            => 'required|numeric',
            'chranic_disease_id' => 'nullable|exists:chranic_diseases,id',
            'ragite_id'          => 'required|exists:ragites,id',
            'doctor_id'          => 'required',
        ];
    }
}
