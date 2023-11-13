<?php

namespace App\Http\Requests\Doctor\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class AddNewRageteRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function __construct() {
        request()['doctor_id'] = provider('doctor')->id;
    }

    public function rules() {
        return [
            'doctor_id' => 'required',
            'image'     => 'required|image',
        ];
    }
}
