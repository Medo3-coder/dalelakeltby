<?php

namespace App\Http\Requests\Store\Rule;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest {

    public function authorize() {
        return true;
    }

    public function __construct() {
        request()['parent_id']   = provider('store')->id;
        request()['is_approved'] = 'accepted';
        request()['is_active']   = 1;
    }

    public function rules() {
        return [
            'is_approved'           => 'nullable',
            'is_active'             => 'nullable',
            'parent_id'             => 'required',
            'name'                  => 'required|max:200',
            'role_name'             => 'required|max:200',
            'country_code'          => 'required|exists:countries,key',
            'phone'                 => 'required|min:8|max:12|unique:doctors,phone,NULL,id,deleted_at,NULL',
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
            'permissions'           => 'required|array',
        ];
    }
}
