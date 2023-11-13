<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCoupon extends BaseModel
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
