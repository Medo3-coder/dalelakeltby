<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderStoreCoupon extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'store_coupon_id',
        'order_id',
        'coupon',
        'status',
    ];

    public function store() {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function storeCoupon() {
        return $this->belongsTo(storeCoupon::class, 'store_coupon_id');
    }

    public function provider() {
        return $this->morphTo('userable');
    }
}
