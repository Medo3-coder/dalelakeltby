<?php

namespace App\Http\Requests\Doctor\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    public function custom()
    {
        $rules = [
            'name.*'                    =>  'required|string|min:3|max:199',
            'address.*'                 =>  'required|min:3|max:199',
            'address_map.*'             =>  'required|min:3|max:199',
            'lat.*'                     =>  'required|between:-90,90',
            'lng.*'                     =>  'required|between:-180,180',
            'comerical_record.*'        =>  'required|numeric|digits_between:16,20',
            'index'                     =>  'required',
            'ids.*'                     =>  'required',
            'detection_price.*'         =>  'required|numeric'

        ];

        $attributes = [
            'name.*'                    =>  __('doctor.doctor.name'),
            'address.*'                 =>  __('doctor.doctor.address'),
            'comerical_record.*'        =>  __('doctor.doctor.comerical_record'),
            'detection_price.*'         =>  __('doctor.detection_price')
        ];

        foreach (request()['index'] as $key){

            $attributes['images-' . $key]                         = __('doctor.doctor.images');
            $attributes['images-' . $key . '.*']                  = __('doctor.doctor.images');

            if (request()['ids'][$key] != 0){
                $rules['images-' . $key . '.*']                       = 'nullable|image';
            }else{
                $rules['images-' . $key . '.*']                       = 'required|image';
            }

        }


        return [
            'rules'         =>  $rules,
            'attributes'    =>  $attributes
        ];



    }


    public function rules()
    {
        return $this->custom()['rules'];
    }

    public function attributes()
    {
        return $this->custom()['attributes'];
    }

}
