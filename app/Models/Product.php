<?php

namespace App\Models;

use App\Traits\Helpers;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends BaseModel {
    use HasFactory, HasTranslations, UploadTrait, Helpers,SoftDeletes;
    const IMAGEPATH     = 'products';
    protected $fillable = ['name', 'image', 'discount_price', 'product_category_id', 'desc', 'type', 'available', 'store_id', 'product_num', 'date_of_supply', 'effective_material', 'category_type', 'counter', ''];

    public $translatable = ['name', 'desc'];

    public function scopePopular($query ,$type){

        return $query->where(['category_type' => $type])->where('counter' ,'!=' ,0)->orderBy('counter' ,'desc');
    }

    public function getPriceAttribute() {
        $firstGroup = $this->groupOne();
        if (Carbon::parse($firstGroup->to)->isPast()) {
            return $firstGroup->price;
        }
        return $firstGroup->discount_price;
    }

    public function getDiscountAttribute() {
        $firstGroup = $this->groupOne();
        if (Carbon::parse($firstGroup->to)->isPast()) {
            return 0;
        }
        return $firstGroup->price - $firstGroup->discount_price;
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function productfeatures() {
        return $this->hasMany(ProductFeature::class);
    }

    public function groups() {
        return $this->hasMany(ProductGroup::class);
    }

    public function groupOne() {
        return $this->groups()->where('properities', null)->first();
    }

    public function price() {
        $lang = app()->getLocale();

        if ($this->type == 'simple') {
            $sar         = trans('store.Dinar');
            $group       = $this->groups()->first();
            $hasDiscount = 0;
            if ($group && $group->discount_price != NULL && $group->discount_price > 0) {

                $paymentDate = date('Y-m-d');
                $paymentDate = date('Y-m-d', strtotime($paymentDate));

                if ($group->from == NULL) {
                    $contractDateBegin = date('Y-m-d');
                } else {
                    $contractDateBegin = date('Y-m-d', strtotime($group->from));
                }

                if ($group->to == NULL) {
                    $datetime        = new DateTime('tomorrow');
                    $contractDateEnd = $datetime->format('Y-m-d');
                } else {
                    $contractDateEnd = date('Y-m-d', strtotime($group->to));
                }

                if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                    $price       = $group->discount_price;
                    $hasDiscount = 1;
                }
            }
            if ($hasDiscount == 1) {
                if ($lang == 'ar') {
                    $price        = $this->convert2arabic($price);
                    $group->price = $this->convert2arabic($group->price);
                }
                return $price . " " . $sar;
            } else {
                if ($lang == 'ar') {
                    if ($group) {
                        $group->price = $this->convert2arabic($group->price);
                        return $group->price . '  ' . $sar;
                    }
                } else {
                    if ($group) {
                        return $group->price . ' ' . $sar;
                    }
                }

            }
        } else {
            return trans('store.price_according_to_choice');
        }
    }

    public function display_price_one()
    {
        $sar = trans('store.Dinar');
        $group = $this->groupOne();
        $hasDiscount = 0;
        if($group && $group->discount_price != NULL  && $group->discount_price > 0){

            $paymentDate    = date('Y-m-d');
            $paymentDate    = date('Y-m-d', strtotime($paymentDate));

            if($group->from == NULL){
                $contractDateBegin = date('Y-m-d');
            }else{
                $contractDateBegin = date('Y-m-d', strtotime($group->from));
            }

            if($group->to == NULL){
                $datetime = new DateTime('tomorrow');
                $contractDateEnd =  $datetime->format('Y-m-d');
            }else{
                $contractDateEnd = date('Y-m-d', strtotime($group->to));
            }

            if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                $price =  $group->discount_price;
                $hasDiscount = 1;
            }
        }
        if($hasDiscount == 1){
            return '<span style="color:#EC2F2F">'.$price.' '.$sar.'    </span><del style"color:#989898;"><small>'.$group->price.' '.$sar.'</small></del>';
        }else{
            return '<span style="color:#3DB9B4">'.$group?->price.' '.$sar.'</span>';
        }
    }


    public function display_price(){
        $lang = app()->getLocale();
        if ($this->type == 'simple') {
            $sar         = trans('store.Dinar');
            $group       = $this->groups()->first();
            $hasDiscount = 0;
            if ($group && $group->discount_price != NULL && $group->discount_price > 0) {

                $paymentDate = date('Y-m-d');
                $paymentDate = date('Y-m-d', strtotime($paymentDate));

                if ($group->from == NULL) {
                    $contractDateBegin = date('Y-m-d');
                } else {
                    $contractDateBegin = date('Y-m-d', strtotime($group->from));
                }

                if ($group->to == NULL) {
                    $datetime        = new DateTime('tomorrow');
                    $contractDateEnd = $datetime->format('Y-m-d');
                } else {
                    $contractDateEnd = date('Y-m-d', strtotime($group->to));
                }

                if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                    $price       = $group->discount_price;
                    $hasDiscount = 1;
                }
            }
            if ($hasDiscount == 1) {
                return '<span style="color:#EC2F2F">' . $price . ' ' . $sar . '    </span><del style"color:#989898;"><small>' . $group->price . ' ' . $sar . '</small></del>';
            } else {
                return '<span style="color:#3DB9B4">' . $group?->price . ' ' . $sar . '</span>';
            }
        }else{
            return '<span style="color:#3DB9B4">'.trans('store.price_according_to_choice') .'</span>';
        }
    }

    public function qty() {
        if ($this->type == 'simple') {
            $qty = $this->groups()->first()->in_stock_qty;
        } else {
            $qty = $this->groups()->where('properities', '!=', NULL)->sum('in_stock_qty');
        }
        return $qty;
    }

    public function additives() {
        return $this->hasMany(ProductAdditives::class, 'product_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

}
