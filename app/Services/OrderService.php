<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderInstallment;
use App\Models\OrderProduct;
use App\Notifications\StoreNewOrderNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderService {
    public static function makeOrder(array $data, $provider) {
        DB::beginTransaction();
        try {

            $cartService = new CartService();
            $cartData    = $cartService->getCartMakeOrderDetails($data['store_id'], $provider);

            if ($data['receiving_method'] == 'on_arrival') {
                $cartData['final_total'] -= $cartData['delivery_price'];
                $cartData['delivery_price'] = 0;
            }

            $order = Order::create($data + ([
                'discount'                => $cartData['discount'],
                'vat_amount'              => $cartData['vat_amount'],
                'vat_ratio'               => $cartData['vat_ratio'],
                'final_total'             => $cartData['final_total'],
                'total_price'             => $cartData['total_price'],
                'delivery_price'          => $cartData['delivery_price'],
                'coupon'                  => $cartData['coupon']?->coupon,
                'admin_commission_ratio'  => $cartData['admin_commission_ratio'],
                'admin_commission_amount' => $cartData['admin_commission_amount'],
            ]));

            $orderProducts = [];

            foreach ($cartData['carts'] as $cart) {
                $orderProduct = [
                    'order_id'    => $order->id,
                    'price'       => $cart->single_price,
                    'qty'         => $cart->qty ?? 1,
                    'total_price' => $cart->price,
                ];
                if ($cart->type == 'offer') {
                    $orderProduct['offer_id'] = $cart->offer_id;
                } else {
                    $orderProduct['product_id'] = $cart->productOffer->product_id;
                    $orderProduct['group_id']   = $cart->productOffer->product->groupOne()->id; /// get the first group only !!!!!!!
                }
                $orderProducts[] = new OrderProduct($orderProduct);
            }

            $order->orderProducts()->saveMany($orderProducts);

            if (isset($cartData['coupon'])) {
                $cartData['coupon']->update([
                    'order_id' => $order->id,
                    'status'   => 'used',
                ]);
            }

            $cartData['carts']->each->delete();

            if ($data['payment_type'] == 'installment') { /// the store should create after accept order
                $installments = [];
                for ($i = 0; $i < $data['installment_number']; $i++) {
                    $duration       = $data['installment_days'] / $data['installment_number'];
                    $installments[] = new OrderInstallment([
                        'date'     => Carbon::now()->addDays(($i + 1) * $duration),
                        'duration' => $duration,
                        'amount'   => $cartData['final_total'] / $data['installment_number'],
                    ]);
                }
                $order->installments()->saveMany($installments);
            }

            Notification::send($cartData['store'], new StoreNewOrderNotification(route('store.orders.show', $order->id)));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'msg'    => __('localize.order_sent'),
                'url'    => url()->previous(),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            info('error from OrderService class ,makeOrder function error : ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'msg'    => $e->getMessage(),
            ]);
        }
    }
}
