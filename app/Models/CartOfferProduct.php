<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartOfferProduct extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'qty',
    ];

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_id')->withTrashed();
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
}
