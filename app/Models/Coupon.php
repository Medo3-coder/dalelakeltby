<?php

namespace App\Models;


class Coupon extends BaseModel
{
    protected $fillable = ['code','type','discount','max_discount','expire_date','max_use','use_times','status'];
}
