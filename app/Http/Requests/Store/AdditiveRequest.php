<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class AdditiveRequest extends FormRequest
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
            'name.ar'=>'required|min:3|string',
            'name.en'=>'required|min:3|string',
            'name.kur'=>'required|min:3|string',
        ];
    }

    public function attributes()
    {
        return [
            'name.ar'       =>__('store.category_name_ar'),
            'name.en'       =>__('store.category_name_en'),
            'name.kur'      =>__('store.category_name_kur'),
        ];
    }
}
