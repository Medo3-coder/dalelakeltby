<?php

namespace App\Http\Requests\Lab\MedicalTest;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest {

    public function __construct() {
        request()['lab_id'] = provider('lab')->id;
    }

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'lab_id'          => 'required',
            'lab_category_id' => 'required|exists:lab_categories,id',
            'sub_category_id' => 'required|exists:lab_categories,id',
            'price'           => 'required|numeric',
            'normal_range'    => 'required|max:200',
            'unit'            => 'required|max:200',
        ];
    }
}
