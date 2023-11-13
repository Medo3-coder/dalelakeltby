<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class Offer extends BaseModel {
    use HasFactory, HasTranslations, UploadTrait,SoftDeletes;

    const IMAGEPATH = 'offers';

    public $translatable = ['name'];
    protected $guarded   = [];

    public function scopeValid($query) {
        return $query->whereDate('end_offer', '>', now());
    }

    public function products() {
        return $this->hasMany(OfferProduct::class, 'offer_id');
    }

    public function store() {
        return $this->belongsTo(Store::class, 'store_id')->withTrashed();
    }

    public function getPriceAttribute() {
        if (Carbon::parse($this->end_offer)->isPast()) {
            return DB::table('products')
                ->whereIn('products.id', $this->products->pluck('product_id')->toArray())
                ->select(['*', DB::raw("(select price from product_groups where product_id = products.id and properities = null limit 1) as p")])
                ->join('product_groups', 'product_groups.product_id', '=', 'products.id')
                ->groupBy('products.id')
                ->get()->sum('price');
        }
        return $this->offer_price;
    }

    public function getDiscountAttribute() {
        if (Carbon::parse($this->end_offer)->isPast()) {
            return 0;
        }
        return $this->offer_discount;
    }
}
