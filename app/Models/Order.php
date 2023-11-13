<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
    use UploadTrait, SoftDeletes;

    protected $fillable = [
        'lab_id',
        'pharmacist_id',
        'store_id',
        'pharmacy_branch_id',
        'lab_branch_id',
        'payment_type',
        'payment_status',
        'receiving_method',
        'status',
        'order_num',
        'deliver_lat',
        'deliver_lng',
        'address',
        'deliver_date',
        'prepare_time',
        'cancel_reason',
        'vat_amount',
        'vat_ratio',
        'final_total',
        'total_price',
        'delivery_price',
        'coupon',
        'discount',
        'installment_days',
        'installment_number',
        'admin_commission_ratio',
        'admin_commission_amount',
        'notes',
        'status_installment',
    ];

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function pharmacist() {
        return $this->belongsTo(Pharmacist::class)->withTrashed();
    }

    public function pharmacyBranch() {
        return $this->belongsTo(PharmacyBranch::class, 'pharmacy_branch_id')->withTrashed();
    }

    public function store() {
        return $this->belongsTo(Store::class)->withTrashed();
    }


    public function orderproducts() {
        return $this->hasMany(OrderProduct::class)->withTrashed();
    }

    public function getPaymentTypeTransAttribute() {
        return __('store.' . $this->attributes['payment_type']);
    }

    public function pharmacy() {
        return $this->belongsTo(Pharmacist::class, 'pharmacist_id')->withTrashed();
    }

    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id')->withTrashed();
    }

    public function labBranch() {
        return $this->belongsTo(LabBranch::class)->withTrashed();
    }

    public function statusHistory() {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function installments() {
        return $this->hasMany(OrderInstallment::class, 'order_id');
    }

    public function offers() {
        return $this->hasManyThrough(Offer::class, OrderProduct::class, 'order_id', 'id')->withTrashed();
    }

    public function products() {
        return $this->hasManyThrough(Product::class, OrderProduct::class, 'product_id', 'id')->withTrashed();
    }

    public function coupon() {
        return $this->hasOne(ProviderStoreCoupon::class, 'order_id');
    }

    // public function acceptedOffer() {
    //     //return $this->belongsTo(Offer::class, 'accepted_offer_id');
    // }

    public function scopeSearch($query, $searchArray = []) {
        $query->where(function ($query) use ($searchArray) {
            if ($searchArray) {
                foreach ($searchArray as $key => $value) {
                    if (str_contains($key, '_id')) {
                        if (null != $value) {
                            $query->Where($key, $value);
                        }
                    } elseif ('order' == $key) {
                    } elseif ('created_at_min' == $key) {
                        if (null != $value) {
                            $query->WhereDate('created_at', '>=', $value);
                        }
                    } elseif ('created_at_max' == $key) {
                        if (null != $value) {
                            $query->WhereDate('created_at', '<=', $value);
                        }
                    } else {
                        if (null != $value) {
                            $query->Where($key, 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        });
        return $query->orderBy('created_at', request()->searchArray && request()->searchArray['order'] ? request()->searchArray['order'] : 'DESC');
    }

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $lastId           = self::max('id') ?? 0;
            $model->order_num = date('Y') . ($lastId + 1);
        });
    }

}
