<?php

namespace App\Http\Requests\Doctor\Profile;

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
            'email'             =>  'required|unique:doctors,email,' . authUser('doctor')->id,
            'phone'             =>  'required|numeric|digits_between:9,10|unique:doctors,phone,' . authUser('doctor')->id,
            'country_code'      =>  'required|exists:countries,key',
            'identity_number'   =>  'required|numeric|digits_between:16,20',
            'image'             =>  'nullable|image',
            'age'               =>  'required|numeric',
            'experience_years'  =>  'required',
            'category_id'       =>  'required|exists:categories,id'
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
