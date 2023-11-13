<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseApiRequest;

class ChargeWalletRequest extends BaseApiRequest {
    public function rules() {
        return [
            'amount' => 'required|numeric|min:5',
        ];
    }
}
