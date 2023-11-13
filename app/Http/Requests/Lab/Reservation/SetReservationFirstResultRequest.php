<?php

namespace App\Http\Requests\Lab\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class SetReservationFirstResultRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function custom() {
        $rules = [
            'lap_results'                                  => 'required|array',
            'lap_results.*.Lab_subcategory_reservation_id' => 'required|exists:lab_subcategory_reservations,id',
            'lap_results.*.result'                         => 'required',
            'images'                                       => 'nullable|array',
            'images.*'                                     => 'required|image',
            'lab_report'                                   => 'required',
            'reservation_id'                               => 'required',
        ];

        $attributes = [];

        foreach (request()->lap_results as $index => $lap_result) {
            $attributes['lap_results.' . $index . '.Lab_subcategory_reservation_id'] = __('doctor.the_test');
            $attributes['lap_results.' . $index . '.result']                         = __('doctor.lab_result');
        }

        return [
            'rules'      => $rules,
            'attributes' => $attributes,
        ];

    }

    public function rules() {
        return $this->custom()['rules'];
    }

    public function attributes() {
        return $this->custom()['attributes'];
    }

}
