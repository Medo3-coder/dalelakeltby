<?php

namespace App\Http\Requests\Store\Products;

use Illuminate\Foundation\Http\FormRequest;

class GroupsRequest extends FormRequest
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
            'group_id'                  =>  'nullable',
            'product_id'                =>  'required|exists:products,id',
            'image'                     =>  'required_without:group_id|nullable|image',
            'ids'                       =>  'required',
            'price'                     =>  'required|numeric',
            'discount_price'            =>  'nullable|numeric',
            'in_stock_qty'              =>  'required|numeric',
            'desc.ar'                   =>  'required|string|min:3' ,
            'desc.en'                   =>  'required|string|min:3' ,
            'desc.kur'                  =>  'required|string|min:3' ,
        ];
    }

    public function attributes()
    {
        return [
            'image'                     =>  __('store.image_group'),
            'price'                     =>  __('store.price'),
            'discount_price'            =>  __('store.The price after discount'),
            'in_stock_qty'              =>  __('store.Quantity in stock'),
            'desc.ar'                   =>  __('store.desc_groups_ar') ,
            'desc.en'                   =>  __('store.desc_groups_en') ,
            'desc.kur'                  =>  __('store.desc_groups_kur') ,
        ];
    }

    public function messages()
    {
        return [
            'image.required_without'    =>__('store.image required'),
            'image.image'               =>__('store.image image'),
        ];
    }
}
