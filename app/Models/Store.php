<?php

namespace App\Models;

namespace App\Models;
use App\Http\Resources\Api\UserResource;
use App\Traits\SmsTrait;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Store extends Authenticatable {
    const IMAGEPATH = 'stores';
    use HasFactory, Notifiable, UploadTrait, HasApiTokens, SmsTrait, SoftDeletes;
    protected $fillable = ['name', 'email', 'password', 'image', 'phone', 'country_code', 'identity_number', 'identity_image', 'is_blocked', 'is_active', 'active', 'is_approved', 'code', 'code_expire', 'parent_id', 'role_name', 'delivery_price'];

    const FILES = [
        'image',
        'identity_image',
    ];

    public function scopePopular($query) {
        $storeIds = DB::table('orders')
            ->select('store_id', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('store_id')
            ->orderBy('total_orders', 'desc')
            ->pluck('store_id');

        $query->whereIn('id', $storeIds)
            ->where(['is_blocked' => '0', 'is_active' => '1', 'is_approved' => 'accepted'])
            ->orderByRaw(DB::raw("FIELD(id, " . implode(',', $storeIds->toArray()) . ")"));
    }

    public function employees() {
        return $this->hasMany(Store::class, 'parent_id');
    }

    public function firstBranch() {
        return $this->branches()->first();
    }

    public function coupons() {
        return $this->hasMany(StoreCoupon::class);
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function roles() {
        return $this->morphMany(ProviderRule::class, 'roleable');
    }

    public function permits() {
        return $this->hasMany(StorePermit::class, 'store_id');
    }

    public function suggestions() {
        return $this->morphMany(Suggestion::class, 'senderable');
    }

    public function offers() {
        return $this->hasMany(Offer::class, 'store_id');
    }

    public function branches() {
        return $this->hasMany(StoreBranch::class);
    }

    public function devices() {
        return $this->morphMany(Device::class, 'morph');
    }

    public function additives() {
        return $this->hasMany(ProductAdditiveCategory::class, 'store_id');
    }

    public function getFullPhoneAttribute() {
        return $this->attributes['country_code'] . $this->attributes['phone'];
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function images() {
        return $this->hasManyThrough(StoreBranchImage::class, StoreBranch::class);
    }

    public function getImageAttribute() {
        if ($this->attributes['image']) {
            $image = $this->getImage($this->attributes['image'], 'stores');
        } else {
            $image = $this->defaultImage('stores');
        }
        return $image;
    }

    public function setImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], 'stores') : '';
                $this->attributes['image'] = $this->uploadeImage($value, 'stores');
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getIdentityImageAttribute() {
        if ($this->attributes['identity_image']) {
            $image = $this->getImage($this->attributes['identity_image'], 'stores');
        } else {
            $image = $this->defaultImage('stores');
        }
        return $image;
    }

    public function setIdentityImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['identity_image']) ? $this->deleteFile($this->attributes['identity_image'], 'stores') : '';
                $this->attributes['identity_image'] = $this->uploadeImage($value, 'stores');
            } else {
                $this->attributes['identity_image'] = $value;
            }
        }
    }

    public function setPasswordAttribute($value) {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getPrefixAttribute() {
        return 'store';
    }

    public function sendVerificationCode() {
        $this->update([
            'code'        => $this->activationCode(),
            'code_expire' => Carbon::now()->addMinute(),
        ]);

        $msg = trans('api.activeCode');
        $this->sendSms($this->full_phone, $msg . $this->code);
        return ['user' => new UserResource($this->refresh())];
    }

    private function activationCode() {
        return 123456;
        return mt_rand(1111, 9999);
    }

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
                    } elseif ('popular_stores' == $key && null != $value) {
                        $storeIds = DB::table('orders')
                            ->select('store_id', DB::raw('COUNT(*) as total_orders'))
                            ->groupBy('store_id')
                            ->orderBy('total_orders', 'desc')
                            ->pluck('store_id');

                        $query->whereIn('id', $storeIds)
                            ->orderByRaw(DB::raw("FIELD(id, " . implode(',', $storeIds->toArray()) . ")"));
                    } elseif ('nearst_stores' == $key && null != $value) {
                        $query->whereHas('branches', function ($branches) {
                            $branches->select(DB::raw('*, ( 6371000 * acos( cos( radians(' . provider(request()->segment(1))->branches()->first()->lat . ') )
                                * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . provider(request()->segment(1))->branches()->first()->lng . ') )
                                + sin( radians(' . provider(request()->segment(1))->branches()->first()->lat . ') ) * sin( radians( lat ) ) ) ) AS distance'))
                                ->having('distance', '<', 50)
                                ->orderBy('distance');
                        });
                    } else {
                        if ('keyword' != $value) {
                            $query->Where('name', 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        });
        if (isset($searchArray['popular_stores']) || isset($searchArray['nearst_stores'])) {
            return $query->where(['is_active' => true, 'is_blocked' => false, 'is_approved' => 'accepted']);
        }
        return $query->where(['is_active' => true, 'is_blocked' => false, 'is_approved' => 'accepted'])->orderBy('id', 'DESC');
    }

    public function scopeFilter($query, $searchArray = []) {
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
                        if ('keyword' != $value) {
                            $query->Where('name', 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        });
        return $query->where(['is_active' => true, 'is_blocked' => false, 'is_approved' => 'accepted'])->orderBy('id', 'DESC');
    }
    public static function boot() {
        parent::boot();
        /* creating, created, updating, updated, deleting, deleted, forceDeleted, restored */
        static::deleted(function ($model) {
            foreach (static::FILES as $file) {
                $model->deleteFile($model->attributes[$file], static::IMAGEPATH);
            }
        });
    }
}
