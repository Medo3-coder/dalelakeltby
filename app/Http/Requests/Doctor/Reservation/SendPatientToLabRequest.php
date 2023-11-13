<?php

namespace App\Http\Requests\Doctor\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class SendPatientToLabRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'lab_category_id'       => 'required',
            'lab_id'                => 'required',
            'reservation_id'        => 'required',
            'sub_category_lab_id'   => 'required|array',
            'sub_category_lab_id.*' => 'required|exists:sub_category_labs,id',
            'date'                  => 'required|date',
            'time'                  => 'required',
            'details'               => 'nullable',
        ];
    }
}
