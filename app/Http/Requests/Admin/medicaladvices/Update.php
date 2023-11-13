<?php

namespace App\Http\Requests\Admin\medicaladvices;

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
            'title.ar'        => 'required|max:160',
            'title.en'        => 'required|max:160',
            'title.kur'       => 'required|max:160',
            'description.ar'  => 'required',
            'description.en'  => 'required',
            'description.kur' => 'required',
            'images'          => 'nullable|array',
            'images.*'        => 'nullable|image',
        ];
    }
}
