<?php

namespace App\Models;

use App\Services\CartService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'lab_id',
        'pharmacy_id',
        'store_id',
        'offer_id',
        'qty',
    ];

    public function getSinglePriceAttribute() {
        if ($this->type == 'offer') {
            return $this->offer->price;
        }
        return $this->productOffer->product->price;
    }

    public function getPriceAttribute() {
        return CartService::getCartPrice($this);
    }

    public function getDiscountAttribute() {
        return CartService::getCartDiscount($this);
    }

    public function getNameAttribute() {
        if ($this->type == 'product') {
            return $this->productOffer->product->name;
        }
        return $this->offer->name;
    }

    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    public function coupon() {
        return $this->hasOne(ProviderStoreCoupon::class, 'cart_id');
    }

    public function pharmacy() {
        return $this->belongsTo(Pharmacist::class, 'pharmacy_id')->withTrashed();
    }

    public function store() {
        return $this->belongsTo(Store::class, 'store_id')->withTrashed();
    }

    public function offer() {
        return $this->belongsTo(Offer::class, 'offer_id')->withTrashed();
    }

    public function products() {
        return $this->hasMany(CartOfferProduct::class, 'cart_id')->withTrashed();
    }

    public function productOffer() {
        return $this->hasOne(CartOfferProduct::class, 'cart_id')->withTrashed();
    }

}
