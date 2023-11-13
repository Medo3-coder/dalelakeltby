<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ChargeWalletRequest;
use App\Traits\ResponseTrait;

class UserController extends Controller {
    use ResponseTrait;

    public function chargeWallet(ChargeWalletRequest $request) {
        $user = auth()->user();
        $user->update([
            'wallet_balance' => $user->wallet_balance + $request->amount,
        ]);

        return $this->successMsg(__('apis.balance_added_to_wallet'));
    }

    public function wallet(){
        return $this->successData([
            'wallet_balance' => auth()->user()->wallet_balance,
            'currency'           => __('site.currency'),
        ]);
    }

}
