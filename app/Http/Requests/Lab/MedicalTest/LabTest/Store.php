<?php

namespace App\Http\Requests\Lab\MedicalTest\LabTest;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'sub_category_lab_id' => 'required|exists:sub_category_labs,id',
            'name'                => 'required',
            'price'               => 'required|numeric',
            'normal_range'        => 'required|max:200',
            'unit'                => 'required|max:200',
        ];
    }
}
