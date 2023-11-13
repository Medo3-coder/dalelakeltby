<?php

namespace App\Http\Requests\Store\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'image'                     => 'nullable|image' ,
            'name.ar'                   => 'required|string|min:3|max:199' ,
            'name.en'                   => 'required|string|min:3|max:199' ,
            'name.kur'                  => 'required|string|min:3|max:199' ,
            'price'                     => 'required|numeric|min:0' ,
            'discount_price'            => 'nullable|required_with:from|required_with:to|numeric|lt:price',
            'from'                      => 'nullable|required_with:discount_price|date|after:' . now()->subDay()->format('d-m-Y') ,
            'to'                        => 'required_with:discount_price|date|after:from|nullable' ,
            'in_stock_type'             => 'required|in:out,in' ,
            'in_stock_sku'              => 'required|unique:product_groups,in_stock_sku,'.$this->group_one_id ,
            'in_stock_qty'              => 'required|numeric' ,
            'type'                      => 'required|in:simple,multiple' ,
            'available'                 => 'required|in:true,false' ,
            'desc.ar'                   => 'required|string|min:3' ,
            'desc.en'                   => 'required|string|min:3' ,
            'desc.kur'                  => 'required|string|min:3' ,
            'category_type'             => 'required|in:equipment,medicine' ,
            'date_of_supply'            => 'required|date',
            'effective_material'        => 'nullable|required_if:category_type,medicine|min:3|max:199',
            'images.*'                  =>  'nullable|image',
        ];
    }

    public function attributes()
    {
        return [
            'image'                     =>  __('store.product image') ,
            'name.ar'                   =>  __('store.product_name_ar') ,
            'name.en'                   =>  __('store.product_name_en') ,
            'name.kur'                  =>  __('store.product_name_kur') ,
            'price'                     =>  __('store.Product price') ,
            'discount_price'            =>  __('store.Product price after discount'),
            'from'                      =>  __('store.from')   ,
            'to'                        =>  __('store.to') ,
            'in_stock_type'             =>  __('store.stocked'),
            'in_stock_sku'              =>  __('store.SKU (Stock Keeping Unit)') ,
            'in_stock_qty'              =>  __('store.Quantity in stock') ,
            'available'                 =>  __('store.product status') ,
            'desc.ar'                   =>  __('store.product_desc_ar') ,
            'desc.en'                   =>  __('store.product_desc_en') ,
            'desc.kur'                  =>  __('store.product_desc_kur') ,
            'type'                      =>  __('store.Product Type') ,
            'category_type'             =>  __('store.product category') ,
            'date_of_supply'            =>  __('store.date of supply') ,
            'effective_material'        =>  __('store.Active substances'),
            'images.*'                  =>  __('store.Product pictures')

        ];
    }

    public function messages()
    {
        return [
            'effective_material.required_if'    =>  __('store.Active substances') . ' ' . __('store.required')
        ];
    }
}
