<?php

namespace App\Http\Requests\Admin\cities;

use Illuminate\Foundation\Http\FormRequest;

class store extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name.ar'   => 'required|max:191',
            'name.en'   => 'required|max:191',
            'name.kur'   => 'required|max:191',
            'country_id' => 'required|exists:countries,id',
        ];
    }
}
