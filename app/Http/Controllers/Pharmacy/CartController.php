<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CartController extends Controller {

    public function index() {
        $carts = provider('pharmacy')->carts()->get()->groupBy('store_id');
        return view('providers_dashboards.pharmacy.cart.index', compact('carts'));
    }

    public function addOffer(Request $request, $offer_id) {

        $data = [
            'pharmacist_id' => provider('pharmacy')->id,
            'type'          => 'offer',
            'qty'           => $request->qty,
            'offer_id'      => $offer_id,
        ];

        if ((new CartService)->addToCart($data)) {
            return response()->json([
                'status' => 'success',
                'msg'    => __('localize.added_to_cart'),
            ]);
        }

        return response()->json(['status' => 'fail', 'msg' => __('apis.error')]);
    }

    public function addProduct(Request $request, $product_id) {

        $data = [
            'pharmacist_id' => provider('pharmacy')->id,
            'type'          => 'product',
            'qty'           => $request->qty,
            'product_id'    => $product_id,
        ];

        if ((new CartService)->addToCart($data)) {
            return response()->json([
                'status' => 'success',
                'msg'    => __('localize.added_to_cart'),
            ]);
        }

        return response()->json(['status' => 'fail', 'msg' => __('apis.error')]);
    }

    public function makeOrderGetData($store_id) {
        $cartService  = new CartService();
        $orderDeyails = $cartService->getCartMakeOrderDetails($store_id, provider('pharmacy'));

        if (isset($orderDeyails['status']) && $orderDeyails['status'] == 'fail') {
            return response()->json($orderDeyails);
        }

        return response()->json([
            'status' => 'success',
            'html'   => view('providers_dashboards.pharmacy.cart.make_order_modal', $orderDeyails)->render(),
        ]);
    }

    public function change(Request $request) {
        if ($request->operation && $request->cart) {
            $cart = provider('pharmacy')->carts()->findOrFail($request->cart);
            switch ($request->operation) {
            case 'increment':
                $qty = $cart->qty ?? 1;
                $cart->update([
                    'qty' => $qty + 1,
                ]);
                break;
            case 'decrement':
                $qty = $cart->qty > 1 ? $cart->qty - 1 : 1;
                $cart->update([
                    'qty' => $qty,
                ]);
                break;
            }

            $cartService = new CartService();

            $cartDetails = $cartService->getCartMakeOrderDetails($cart->store_id, provider('pharmacy'));

            if (isset($cartDetails['status']) && $cartDetails['status'] == 'fail') {
                return response()->json($cartDetails);
            }

            return response()->json([
                'status' => 'success',
                'header' => view('providers_dashboards.pharmacy.cart._make_order_modal_header', $cartDetails)->render(),
                'footer' => view('providers_dashboards.pharmacy.cart._make_order_modal_footer', $cartDetails)->render(),
            ]);
        }
    }

    public function saveCoupon(Request $request) {
        $provider = provider('pharmacy');
        $carts    = $provider->carts()->where('store_id', $request->store);
        return CouponService::saveCoupon($request, $carts, $provider);
    }

    public function deleteCoupon(Request $request) {
        $provider = provider('pharmacy');
        return CouponService::deleteCoupon($request, $provider);
    }
}
