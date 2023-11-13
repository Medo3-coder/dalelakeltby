<?php

namespace App\Services;

use App\Models\CartOfferProduct;
use App\Models\Offer;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Store;
use Exception;

class CartService {

    protected $provider;

    public function __construct() {
        $this->provider = provider(request()->segment(1));
    }

    public function addToCart(array $data) {
        try {
            if ($data['type'] === 'product') {

                $product = Product::findOrFail($data['product_id']);
                $cart    = $this->provider->carts()->create($data + (['store_id' => $product->store_id])); //(pharmasist_id or lab_id) and type
                $cart->products()->create($data); // product_id and qty keys

            } elseif ($data['type'] === 'offer') {

                $offer = Offer::with('products')->findOrFail($data['offer_id']);
                $cart  = $this->provider->carts()->create($data + (['store_id' => $offer->store_id])); //(pharmasist_id or lab_id) and type and offer_qty

                $products = [];
                foreach ($offer->products as $product) {
                    $products[] = new CartOfferProduct(['product_id' => $product->product->id]);
                }
                $cart->products()->saveMany($products);
            }

            return true;

        } catch (Exception $e) {
            info('error from add to cart service on addToCart function : ' . $e->getMessage());
            return false;
        }
    }

    public static function calculateDiscount($storeCarts) {
        $discount = 0;
        $storeCarts->each(function ($cart) use (&$discount) {
            $discount += self::getCartDiscount($cart);
        });
        return $discount;
    }

    public static function getCartDiscount($cart) {
        if ($cart->type == 'offer') {
            return $cart->offer->discount * ($cart->qty ?? 1);
        } elseif ($cart->type == 'product') {
            $productOffer = $cart->productOffer;
            return $productOffer->product->discount * ($cart->qty ?? 1);
        }
        return null;
    }

    public static function calculatePrice($storeCarts) {
        $price = 0;
        $storeCarts->each(function ($cart) use (&$price) {
            $price += self::getCartPrice($cart);
        });
        return $price;
    }

    public static function getCartPrice($cart) {
        if ($cart->type == 'offer') {
            return $cart->offer->price * ($cart->qty ?? 1);
        } elseif ($cart->type == 'product') {
            $productOffer = $cart->productOffer;
            return $productOffer->product->price * ($cart->qty ?? 1);
        }
        return null;
    }

    public function getCartMakeOrderDetails($store_id, $provider) {
        try {
            $store = Store::findOrFail($store_id);
            $carts = $provider->carts()->where('store_id', $store_id)->get();

            $branches = $provider->branches;

            // price of the offers and products in the cart without dicount
            $price = self::calculatePrice($carts);

            // delivery price from store profile
            $delivery_price = $store->delivery_price;
            // vat ratio from settings precentage
            $vat_ratio = doubleval(SiteSetting::where('key', 'vat_ratio')->first()->value);
            // the vat amount is the vat ratio in precentage * the products price
            $vat_amount = ($vat_ratio / 100) * $price;
            // total price is  products or offers price
            $total_price = $price;
            // coupon
            $coupon = $provider->coupons()->where([
                'store_id' => $store_id,
                'status'   => 'not_used',
            ])->first();

            $discount = null;

            // check the coupon and is used before ?
            if ($coupon && $provider->orders->where('coupon', $coupon->coupon)->count() == 0) {
                // if there is an error in the checking in the coupon the (checkCoupon) function will get the coupon error message in exception
                $discount    = CouponService::checkCoupon($coupon->coupon, $price, $provider, $store_id);
                $total_price = $price - $discount;
            }
            // the final total is the vat amount + delivery price + products price
            $final_total = $total_price + $vat_amount + $delivery_price;

            $admin_commission_ratio  = doubleval(SiteSetting::where('key', 'admin_commission_ratio')->first()->value);
            $admin_commission_amount = 0;

            return get_defined_vars();

        } catch (Exception $e) {
            info('cart service get Cart Make Order Details in getCartMakeOrderDetails function error : ' . $e->getMessage());
            return ['status' => 'fail', 'msg' => $e->getMessage()];
        }
    }


}