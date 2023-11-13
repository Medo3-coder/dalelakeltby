<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFeatureProperity extends BaseModel
{
    use HasFactory;

    protected $fillable = ['product_feature_id' , 'properity_id'];
    
    public function productfeature(){
        return $this->belongsTo(Productfeature::class);
    }

    public function properity(){
        return $this->belongsTo(Properity::class);
    }
}
