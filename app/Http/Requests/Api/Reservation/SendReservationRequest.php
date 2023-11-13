<?php

namespace App\Http\Requests\Api\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class SendReservationRequest extends FormRequest {
    public function rules() {
        return [
            // for lab reservation
            'lab_id'                => 'nullable|required_if:type,lab|exists:labs,id',
            'lab_category_id'       => 'nullable|required_if:type,lab|exists:lab_categories,id',
            'lab_branch_id'         => 'nullable|required_if:type,lab|exists:lab_branches,id',
            'sub_category_lab_id'   => 'nullable|required_if:type,lab|array',
            'sub_category_lab_id.*' => 'nullable|exists:sub_category_labs,id',

            // for lab reservation
            'doctor_id'             => 'required_if:type,doctor|exists:doctors,id',
            'clinic_id'             => 'required_if:type,doctor|exists:clinics,id',

            'type'                  => 'required|in:doctor,lab',
            'payment_method'        => 'required|in:wallet,sms',

            'lng'                   => 'required',
            'lat'                   => 'required',
            'reservation_for'       => 'required|in:same_person,family',
            'date'                  => 'required|date',
            'time'                  => 'required',
            'details'               => 'required|min:10',
            'paient_name'           => 'nullable|required_if:reservation_for,family',
            'paient_blood_type_id'  => 'nullable|required_if:reservation_for,family|exists:blood_types,id',
            'paient_age'            => 'nullable|required_if:reservation_for,family',
            'paient_weight'         => 'nullable|required_if:reservation_for,family',
            'paient_height'         => 'nullable|required_if:reservation_for,family',
            'paient_height'         => 'nullable|required_if:reservation_for,family',
            'images'                => 'nullable|array',
            'images.*'              => 'nullable',
        ];
    }
}
