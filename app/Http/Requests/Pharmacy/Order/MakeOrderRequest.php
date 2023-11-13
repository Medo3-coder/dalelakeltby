<?php

namespace App\Http\Requests\Pharmacy\Order;

use Illuminate\Foundation\Http\FormRequest;

class MakeOrderRequest extends FormRequest {

    public function __construct() {
        request()['pharmacist_id'] = provider('pharmacy')->id;
        // dd(request()->all());
    }

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'pharmacist_id'      => 'required',
            'store_id'           => 'required|exists:stores,id',
            'deliver_lat'        => 'required|numeric',
            'deliver_lng'        => 'required|numeric',
            'address'            => 'required',
            'coupon'             => 'nullable',
            'pharmacy_branch_id' => 'required|exists:pharmacy_branches,id',
            // 'lab_branch_id'      => 'required|exists:lab_branches,id',
            'receiving_method'   => 'required|in:by_delegate,on_arrival',
            'payment_type'       => 'required|in:installment,cash,online',

            'installment_days'   => 'nullable|required_if:payment_type,installment',
            'installment_number' => 'nullable|required_if:payment_type,installment|numeric',

            'notes'              => 'nullable',
        ];
    }
}

/*
"store_id" => "7"
"deliver_lat" => "30.936119886163887"
"deliver_lng" => "31.34877371003417"
"address" => "برج نور الحمص، مركز أجا، الدقهلية 7536603، مصر"
"receiving_method" => "by_delegate"
"payment_type" => "installment"
"installment_days" => "100"
"installment_number" => "10"
"notes" => "aaaaaaaaaaaaaa"
 */