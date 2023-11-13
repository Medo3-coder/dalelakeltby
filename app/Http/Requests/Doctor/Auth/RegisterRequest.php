<?php

namespace App\Http\Requests\Doctor\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function custom() {
        $rules = [
            'name'                           => 'required|string|min:3|max:199',
            'nickname'                       => 'nullable|string|min:3|max:199',
            'address'                        => 'required|string',
            'age'                            => 'required|numeric',
            'qualifications'                 => 'required|string',
            'abstract'                       => 'required|string',
            'image'                          => 'required|image',
            'country_code'                   => 'required',
            'phone'                          => 'required|numeric|digits_between:8,10|unique:doctors,phone,NULL,id,deleted_at,NULL',
            'email'                          => 'required|email|unique:stores,email,NULL,id,deleted_at,NULL',
            'identity_number'                => 'required|numeric|digits_between:16,20',
            'category_id'                    => 'required|exists:categories,id',
            'city_id'                        => 'required|exists:cities,id',
            'identity_image'                 => 'required|image',
            'experience_years'               => 'required|numeric',
            'graduation_certification_image' => 'required|image',
            'graduation_certification_pdf'   => 'required|mimes:pdf',
            'practice_certification_image'   => 'required|image',
            'practice_certification_pdf'     => 'required|mimes:pdf',
            'experience_certification_image' => 'required|image',
            'experience_certification_pdf'   => 'required|mimes:pdf',

            'password'                       => 'required|min:6',
            'clinics'                        => 'required|array',
            'clinics.*.name'                 => 'required|max:200',
            'clinics.*.detection_price'      => 'required|numeric',
            'clinics.*.lat'                  => 'required',
            'clinics.*.lng'                  => 'required',
            'clinics.*.address'              => 'required',
            'clinics.*.comerical_record'     => 'required',

            'clinics.*.dates'                => 'required|array',
            'clinics.*.dates.*.day'          => 'required',
            'clinics.*.dates.*.from'         => 'required',
            'clinics.*.dates.*.to'           => 'required',

        ];

        $attributes = [];

        foreach (request()->clinics as $index => $clinic) {
            $attributes['clinics.' . $index . '.name']             = __('doctor.clinic_name');
            $attributes['clinics.' . $index . '.detection_price']  = __('doctor.detection_price');
            $attributes['clinics.' . $index . '.lat']              = __('doctor.lat');
            $attributes['clinics.' . $index . '.lng']              = __('doctor.lng');
            $attributes['clinics.' . $index . '.address']          = __('doctor.address');
            $attributes['clinics.' . $index . '.address_map']      = __('translation.doctor_address_map');
            $attributes['clinics.' . $index . '.comerical_record'] = __('doctor.comerical_record');
            $attributes['clinics.' . $index . '.date']             = __('doctor.working_times');

            foreach ($clinic['dates'] as $date_index => $date) {
                $attributes['clinics.' . $index . '.dates.' . $date_index . '.day']  = __('doctor.day');
                $attributes['clinics.' . $index . '.dates.' . $date_index . '.from'] = __('doctor.from');
                $attributes['clinics.' . $index . '.dates.' . $date_index . '.to']   = __('doctor.to');
            }
        }

        $rules['password']              = 'required|min:6|max:199|confirmed';
        $rules['password_confirmation'] = 'required|same:password';

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
