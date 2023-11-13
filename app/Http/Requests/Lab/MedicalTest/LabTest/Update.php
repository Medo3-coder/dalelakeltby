<?php

namespace App\Http\Requests\Lab\MedicalTest\LabTest;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'         => 'required',
            'price'        => 'required|numeric',
            'normal_range' => 'required|max:200',
            'unit'         => 'required|max:200',
        ];
    }
}
