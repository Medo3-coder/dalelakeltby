<?php

namespace App\Http\Requests\Store\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'              =>  'required|min:3|max:199',
            'email'             =>  'required|unique:stores,email,' . authUser('store')->id,
            'phone'             =>  'required|numeric|digits_between:9,10|unique:stores,phone,' . authUser('store')->id,
            'country_code'      =>  'required|exists:countries,key',
            'identity_number'   =>  'required|numeric|digits_between:16,20',
            'image'             =>  'nullable|image',
            'delivery_price'    =>  'required|numeric'
        ];
    }

    public function prepareForValidation()
    {
        $phone = fixPhone($this->phone);
        $this->merge([
            'phone' => $phone ,
        ]);
    }


}
