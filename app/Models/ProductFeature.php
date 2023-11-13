<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends BaseModel
{
    use HasFactory;
    protected $fillable = ['product_id', 'feature_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function productfeatureproperities()
    {
        return $this->hasMany(Productfeatureproperity::class);
    }
}
