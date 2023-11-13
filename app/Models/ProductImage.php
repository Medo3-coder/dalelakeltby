<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends BaseModel
{
    use HasFactory, UploadTrait;

    protected $guarded = [];
    const IMAGEPATH = 'products' ;

}
