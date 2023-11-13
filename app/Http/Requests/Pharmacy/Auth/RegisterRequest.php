<?php

namespace App\Http\Requests\Pharmacy\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {

    // public function __construct() {
    //     dd(request()->all());
    // }

    public function authorize() {
        return true;
    }

    public function custom() {
//        dd(request()->all());
        $rules = [
            'image'                          => 'required|image',
            'name'                           => 'required|string|min:3|max:199',
            'age'                            => 'required|numeric',
            'country_code'                   => 'required',
            'phone'                          => 'required|numeric|digits_between:8,11|unique:stores,phone,NULL,id,deleted_at,NULL',
            'email'                          => 'required|email|unique:stores,email,NULL,id,deleted_at,NULL',
            'identity_number'                => 'required|numeric|digits_between:12,20',
            'identity_image'                 => 'required|image',
            'graduation_certification_image' => 'required|image',
            'graduation_certification_pdf'   => 'required|mimes:pdf',
            'experience_certification_image' => 'required|image',
            'experience_certification_pdf'   => 'required|mimes:pdf',
            'practice_certification_image'   => 'required|image',
            'practice_certification_pdf'     => 'required|mimes:pdf',
            'experience_years'               => 'required|numeric',

            'branches'                       => 'required|array',
            'branches.*.name'                => 'required|max:200',
            'branches.*.lat'                 => 'required',
            'branches.*.lng'                 => 'required',
            'branches.*.address'             => 'required',
            'branches.*.address_map'         => 'required',
            'branches.*.comerical_record'    => 'required',
            'branches.*.images'              => 'required|array',
            'branches.*.images.*'            => 'required|image',

            'branches.*.dates'               => 'required|array',
            'branches.*.dates.*.day'         => 'required',
            'branches.*.dates.*.from'        => 'required',
            'branches.*.dates.*.to'          => 'required',

            'password'                       => 'required|min:6',
            'password_confirmation'          => 'required|same:password',

        ];

        $attributes = [];

        foreach (request()->branches as $index => $clinic) {
            $attributes['branches.' . $index . '.name']             = __('doctor.clinic_name');
            $attributes['branches.' . $index . '.lat']              = __('doctor.lat');
            $attributes['branches.' . $index . '.lng']              = __('doctor.lng');
            $attributes['branches.' . $index . '.address']          = __('doctor.address');
            $attributes['branches.' . $index . '.comerical_record'] = __('doctor.comerical_record');
            $attributes['branches.' . $index . '.dates']            = __('doctor.working_times');
            $attributes['branches.' . $index . '.images']           = __('localize.images');

            foreach ($clinic['dates'] as $date_index => $date) {
                $attributes['branches.' . $index . '.dates.' . $date_index . '.day']  = __('doctor.day');
                $attributes['branches.' . $index . '.dates.' . $date_index . '.from'] = __('doctor.from');
                $attributes['branches.' . $index . '.dates.' . $date_index . '.to']   = __('doctor.to');
            }
        }

        return [
            'rules'      => $rules,
            'attributes' => $attributes,
        ];

    }

    public function rules() {
        return $this->custom()['rules'];
    }

    public function prepareForValidation() {
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code),
        ]);
    }

    public function attributes() {
        return $this->custom()['attributes'];
    }

}
