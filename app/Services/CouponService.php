<?php
namespace App\Services;

use App\Models\Coupon;
use App\Models\StoreCoupon;
use Exception;

class CouponService {

    static function checkCoupon($coupon_num, $total_price, $user, $store_id) {
        if (!$coupon = StoreCoupon::where(['code' => $coupon_num, 'store_id' => $store_id])->first()) {
            throw new Exception(__('apis.not_avilable_coupon'));
        }
        if ($coupon->status == 'closed') {
            throw new Exception(__('apis.not_avilable_coupon'));
        }
        if ($coupon->status == 'usage_end') {
            throw new Exception(__('apis.max_usa_coupon'));
        }

        if ($coupon->expire_date < today() || $coupon->status == 'expire') {
            throw new Exception(__('apis.coupon_end_at', ['date' => date('d-m-Y  h:i A', strtotime($coupon->expire_date))]));
        }

        // if ($user->orders->where('coupon', $coupon_num)->where('store_id', $store_id)->count() == 0) {
        //     return ['msg' => __('apis.used_before'), 'key' => 'fail'];
        // }

        if ($user->coupons()->where([
            'store_id'      => $store_id,
            'coupon'        => $coupon_num,
            'status'        => 'used',
            'userable_id'   => $user->id,
            'userable_type' => \get_class($user),
        ])->first()) {
            throw new Exception(__('apis.used_before_coupon'));
        }

        if ('ratio' == $coupon->type) {
            $disc_amount = $coupon->discount * $total_price / 100;
            if ($disc_amount > $coupon->max_discount) {
                $disc_amount = $coupon->max_discount;
            }
        } else {
            $disc_amount = $coupon->discount;
        }

        return $disc_amount;
    }

    static function saveCoupon($request, $carts, $user) {

        if (!$coupon = StoreCoupon::where(['code' => $request->coupon, 'store_id' => $request->store])->first()) {
            return ['msg' => __('apis.not_avilable_coupon'), 'key' => 'fail'];
        }
        if ($coupon->status == 'closed') {
            return ['msg' => __('apis.not_avilable_coupon'), 'key' => 'fail'];
        }
        if ($coupon->status == 'usage_end') {
            return ['msg' => __('apis.max_usa_coupon'), 'key' => 'fail'];
        }

        if ($coupon->max_use == $coupon->use_times || $coupon->max_use == 0){
            return ['msg' => __('apis.not_avilable_coupon'), 'key' => 'fail'];
        }

        if ($coupon->expire_date < today() || $coupon->status == 'expire') {
            return ['msg' => __('apis.coupon_end_at', ['date' => date('d-m-Y  h:i A', strtotime($coupon->expire_date))]), 'key' => 'fail'];
        }

        // if ($user->orders->where('coupon', $request->coupon)->where('store_id', $request->store)->count() == 0) {
        //     return ['msg' => __('apis.used_before'), 'key' => 'fail'];
        // }



        if ($user->coupons()->where([
            'store_id'      => $request->store,
            'coupon'        => $request->coupon,
            'status'        => 'used',
            'userable_id'   => $user->id,
            'userable_type' => \get_class($user),
        ])->first()) {
            return ['msg' => __('apis.used_before_coupon'), 'key' => 'fail'];
        }



        $user->coupons()->updateOrCreate([
            'store_id'        => $request->store,
            'store_coupon_id' => $coupon->id,
            'coupon'          => $coupon->code,
            'status'          => 'not_used',
        ], []);



        $total_price = CartService::calculatePrice($carts);

        if ('ratio' == $coupon->type) {
            $disc_amount = $coupon->discount * $total_price / 100;
            if ($disc_amount > $coupon->max_discount) {
                $disc_amount = $coupon->max_discount;
            }
        } else {
            $disc_amount = $coupon->discount;
        }



        $cartService = new CartService();

        $cartDetails = $cartService->getCartMakeOrderDetails($request->store, provider(request()->segment(1)));

        if (isset($cartDetails['status']) && $cartDetails['status'] == 'fail') {
            return response()->json($cartDetails);
        }


        return response()->json([
            'msg'         => __('apis.disc_amount') . ' ' . $disc_amount . ' ' . __('site.currency'),
            'status'      => 'success',
            'disc_amount' => $disc_amount,
            'header'      => view('providers_dashboards.lab.cart._make_order_modal_header', $cartDetails)->render(),
            'footer'      => view('providers_dashboards.lab.cart._make_order_modal_footer', $cartDetails)->render(),
        ]);
    }

    public static function deleteCoupon($request, $user) {

        if (!$coupon = StoreCoupon::where(['code' => $request->coupon, 'store_id' => $request->store])->first()) {
            return response()->json(['msg' => __('apis.not_avilable_coupon'), 'status' => 'fail']);
        }

        $user->coupons()->where([
            'store_id'        => $request->store,
            'store_coupon_id' => $coupon->id,
            'coupon'          => $coupon->code,
            'status'          => 'not_used',
        ])->first()->delete();

        $cartService = new CartService();

        $cartDetails = $cartService->getCartMakeOrderDetails($request->store, provider('lab'));

        if (isset($cartDetails['status']) && $cartDetails['status'] == 'fail') {
            return response()->json($cartDetails);
        }

        return response()->json([
            'msg'    => __('apis.deleted'),
            'status' => 'success',
            'header' => view('providers_dashboards.lab.cart._make_order_modal_header', $cartDetails)->render(),
            'footer' => view('providers_dashboards.lab.cart._make_order_modal_footer', $cartDetails)->render(),
        ]);
    }


}