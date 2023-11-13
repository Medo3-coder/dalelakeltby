<?php

namespace App\Http\Requests\Store\Profile;

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
            'ids.*'                     =>  'required'

        ];

        $attributes = [
            'name.*'                    =>  __('store.name'),
            'address.*'                 =>  __('store.address'),
            'comerical_record.*'        =>  __('store.record number')
        ];

        foreach (request()['index'] as $key){

            if (request()['ids'][$key] != 0){
                $rules['images-' . $key . '.*']                       = 'nullable|image';
                $attributes['images-' . $key]                         = __('store.store_images');
                $attributes['images-' . $key . '.*']                  = __('store.store_images');
            }else{
                $rules['images-' . $key . '.*']                       = 'required|image';
                $attributes['images-' . $key]                         = __('store.branch_images');
                $attributes['images-' . $key . '.*']                  = __('store.branch_images');
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
