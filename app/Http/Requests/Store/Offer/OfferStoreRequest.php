<?php

namespace App\Http\Requests\Store\Offer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class OfferStoreRequest extends FormRequest
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
            'image'                 =>  'required|image',
            'name.ar'               =>  'required|min:3',
            'name.en'               =>  'required|min:3',
            'name.kur'              =>  'required|min:3',
            'offer_discount'        =>  'nullable|numeric',
            'offer_price'           =>  'required|numeric',
            'bonus'                 =>  'required|numeric',
            'product_id.*'          =>  'required|exists:products,id',
            'product_id'            =>  'required|exists:products,id',
            'end_offer'             =>  'required|date|after:' . Carbon::now()->addHour()->format('d-m-Y g:i:s A'),
            'type'                  =>  'required|in:products,equipment'
        ];
    }

    public function attributes()
    {
        return [
            'image'                 =>  __('store.offer_image'),
            'name.ar'               =>  __('store.offer_name_ar'),
            'name.en'               =>  __('store.offer_name_en'),
            'name.kur'              =>  __('store.offer_name_kur'),
            'offer_discount'        =>  __('store.Discount'),
            'offer_price'           =>  __('store.offer price'),
            'bonus'                 =>  __('store.bonus'),
            'product_id.*'          =>  __('store.products'),
            'product_id'            =>  __('store.products'),
            'end_offer'             =>  __('store.end_offer'),
            'type'                  =>  __('store.offer_type')
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
