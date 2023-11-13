<?php

namespace App\Http\Requests\Api;

class AddComplaintRequest extends BaseApiRequest {

    public function rules() {
        return [
            'name'           => 'required',
            // 'reservation_id' => 'required|exists:reservations,id',
            'complaint'      => 'required',
        ];
    }
}
