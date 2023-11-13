<?php

namespace App\Http\Requests\Store\Products;

use Illuminate\Foundation\Http\FormRequest;

class AdditionRequest extends FormRequest
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
            'name_ar.*'                         =>  'required|min:3',
            'name_en.*'                         =>  'required|min:3',
            'name_kur.*'                        =>  'required|min:3',
            'price.*'                           =>  'required|numeric',
            'discount_price.*'                  =>  'nullable|numeric|lt:price.*',
            'product_additive_category_id.*'    =>  'required|exists:product_additive_categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'name_ar.*'                         =>  __('store.addition_name_ar'),
            'name_en.*'                         =>  __('store.addition_name_en'),
            'name_kur.*'                        =>  __('store.addition_name_kur'),
            'price.*'                           =>  __('store.Addition price'),
            'discount_price.*'                  =>  __('store.Addition price after discount'),
            'product_additive_category_id.*'    =>  __('store.product_additive_category_id'),
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
