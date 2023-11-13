<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductAdditiveCategory extends BaseModel
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    public $translatable = ['name'];

}
