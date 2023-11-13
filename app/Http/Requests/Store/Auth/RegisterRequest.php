<?php

namespace App\Http\Requests\Store\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function custom() {
        $rules = [
            'name'            => 'required|string|min:3|max:199',
            'image'           => 'required|image',
            'phone'           => 'required|numeric|digits_between:9,10|unique:stores,phone,NULL,id,deleted_at,NULL',
            'email'           => 'required|email|unique:stores,email,NULL,id,deleted_at,NULL',
            'identity_number' => 'required|numeric|digits_between:16,20',
            'country_code'    => 'required',
            'identity_image'  => 'required|image',
            'delivery_price'  => 'required|numeric',
        ];

        $attributes = [];

        for ($i = 0; $i <= $this->request->get('index'); $i++) {

            $rules['name-' . $i]                      = 'required|string|distinct|min:3';
            $rules['address-' . $i]                   = 'required|string|distinct|min:3';
            $rules['address_map-' . $i]               = 'required|string|distinct|min:3';
            $rules['lat-' . $i]                       = 'required|between:-90,90';
            $rules['lng-' . $i]                       = 'required|between:-180,180';
            $rules['comerical_record-' . $i]          = 'required|numeric|digits_between:16,20';
            $rules['images-' . $i]                    = 'required|array';
            $rules['images-' . $i . '.*']             = 'required|image';
            $rules['opening_certificate_pdf-' . $i]   = 'required|mimes:pdf';
            $rules['opening_certificate_image-' . $i] = 'required|image';
            if ($i == 0) {
                $attributes['name-' . $i]                      = __('store.store_name');
                $attributes['address-' . $i]                   = __('store.store_address');
                $attributes['comerical_record-' . $i]          = __('store.store_record_number');
                $attributes['opening_certificate_image-' . $i] = __('store.Repository opening certificate (photo)');
                $attributes['opening_certificate_pdf-' . $i]   = __('store.PDF opening certificate stored');
                $attributes['images-' . $i]                    = __('store.stock image');
                $attributes['images-' . $i . '.*']             = __('store.stock image');
            } else {
                $attributes['name-' . $i]                      = __('store.branch_name');
                $attributes['address-' . $i]                   = __('store.branch_address');
                $attributes['comerical_record-' . $i]          = __('store.branch_record_number');
                $attributes['opening_certificate_image-' . $i] = __('store.Branch opening certificate (photo)');
                $attributes['opening_certificate_pdf-' . $i]   = __('store.PDF branch opening certificate');
                $attributes['images-' . $i]                    = __('store.Branch photos');
                $attributes['images-' . $i . '.*']             = __('store.Branch photos');
            }

        }

        $rules['password'] = 'required|min:6|max:199|confirmed';

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
