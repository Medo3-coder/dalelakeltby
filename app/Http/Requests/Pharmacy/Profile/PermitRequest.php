<?php

namespace App\Http\Requests\Pharmacy\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PermitRequest extends FormRequest
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
            'name'      =>  'required|min:3|max:199',
            'image'     =>  'required|image',
            'file'      =>  'required|mimes:pdf'
        ];
    }

    public function attributes()
    {
        return [
            'name'          =>  __('store.permit_name'),
            'image'         =>  __('store.permit_image'),
            'file'          =>  __('store.permit_file'),
        ];
    }
}
