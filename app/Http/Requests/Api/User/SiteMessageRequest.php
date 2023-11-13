<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;

class SiteMessageRequest extends BaseApiRequest {
    public function rules() {
        return [
            'name'         => 'required|max:250',
            'country_code' => 'required',
            'phone'        => 'required|numeric|digits_between:9,10',
            'message'      => 'required',
        ];
    }
}
