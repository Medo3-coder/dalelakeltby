<?php

namespace App\Http\Requests\Api;

class UpdateLocationRequest extends BaseApiRequest {

    public function rules() {
        return [
            'lat'      => 'required|numeric',
            'lng'      => 'required|numeric',
            'map_desc' => 'required',
        ];
    }
}
