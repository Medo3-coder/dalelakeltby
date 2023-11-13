<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\Order\MakeOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller {

    public function make(MakeOrderRequest $request) {
        return OrderService::makeOrder($request->validated() ,provider('lab'));
    }

}
