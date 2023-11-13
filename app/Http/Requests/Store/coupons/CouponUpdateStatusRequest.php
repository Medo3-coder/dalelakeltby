<?php

namespace App\Http\Requests\Store\coupons;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateStatusRequest extends FormRequest
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
    public function __construct() {
        request()['expire_date']    =   date('Y-m-d H:i:s', strtotime(request()['expire_date']));
    }

    public function rules()
    {
        return [
            'id'                    =>  'required|exists:store_coupons,id',
            'type'                  =>  'required|in:ratio,number',
            'discount'              =>  'required|numeric',
            'max_discount'          =>  'required|numeric',
            'expire_date'           =>  'required|after:'.Carbon::now(),
            'max_use'               =>  'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'code'                  =>  __('store.discount code'),
            'type'                  =>  __('store.discount type'),
            'discount'              =>  __('store.discount value'),
            'max_discount'          =>  __('store.The largest value of the discount'),
            'expire_date'           =>  __('store.Expiry date'),
            'max_use'               =>  __('store.The number of times of use'),
        ];
    }
}
