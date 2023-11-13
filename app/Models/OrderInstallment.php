<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInstallment extends Model {
    use HasFactory;

    protected $fillable = [
        'order_id',
        'date',
        'duration',
        'amount',
        'status',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }
}
