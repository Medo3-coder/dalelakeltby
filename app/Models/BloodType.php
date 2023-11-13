<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class BloodType extends BaseModel {
    use SoftDeletes;
    protected $fillable = ['name'];
}
