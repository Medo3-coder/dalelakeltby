<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends BaseModel
{
    use HasFactory, HasTranslations, UploadTrait,SoftDeletes;
    protected $fillable = ['properities','price','desc', 'image','discount_price','from','to','in_stock_type','allow_in_stock_system','in_stock_notification','in_stock_qty','the_great_discount_min_qty','appearance','status','product_id', 'in_stock_sku'];

    public $translatable = ['desc'];

    const IMAGEPATH = 'products/groups' ;

    public function getProperitiesDataAttribute(){
        $properities = [];
        foreach (json_decode($this->properities) as $value) {
            $properity = Properity::find($value);

            if($properity){
                array_push($properities,$properity);
            }
        }
        return  $properities ;
    }

}
