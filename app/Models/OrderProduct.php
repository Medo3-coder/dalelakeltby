<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'offer_id',
        'group_id',
        'price',
        'qty',
        'total_price',
    ];

    public function product() {
        return $this->belongsTo(Product::class)->withTrashed();
    }
    
    public function order() {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }

    public function group() {
        return $this->belongsTo(Order::class, 'group_id')->withTrashed();
    }

    public function offer() {
        return $this->belongsTo(Offer::class, 'offer_id')->withTrashed();
    }

}
