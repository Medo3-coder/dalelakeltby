<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class CancelReason extends BaseModel {
    const IMAGEPATH = 'cancelreasons';

    use HasTranslations,SoftDeletes;
    protected $fillable  = ['reason'];
    public $translatable = ['reason'];

}
