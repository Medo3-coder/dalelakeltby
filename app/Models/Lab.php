<?php

namespace App\Models;
use App\Traits\SmsTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;

class Lab extends Authenticatable {
    use HasFactory, Notifiable, UploadTrait, HasApiTokens, SmsTrait, SoftDeletes;
    const IMAGEPATH     = 'labs';
    const FILES         = ['image', 'identity_image'];
    protected $fillable = ['name', 'phone', 'password', 'city_id', 'country_code', 'email', 'image', 'address', 'identity_id', 'identity_image', 'lab_name', 'is_blocked', 'is_active', 'is_approved', 'category_id', 'rate_avg', 'rate_count', 'parent_id', 'role_name', 'code'];

    public function city() {
        return $this->belongsTo(City::class)->withTrashed();
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function labCategories() {
        return $this->belongsToMany(LabCategory::class, 'categories_labs', 'lab_id', 'lab_category_id')->withPivot('id')->withTrashed();
    }

    public function permits() {
        return $this->hasMany(LabPermit::class);
    }

    public function labSubCategories() {
        return $this->belongsToMany(LabCategory::class, 'sub_category_labs', 'lab_id', 'sub_category_id')->withTrashed();
    }

    public function labSubCategoriesHasMany() {
        return $this->hasMany(SubCategoryLab::class, 'lab_id');
    }

    public function branches() {
        return $this->hasMany(LabBranch::class, 'lab_id')->withTrashed();
    }

    public function firstBranch() {
        return $this->branches()->first();
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id')->withTrashed();
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id')->withTrashed();
    }

    public function roles() {
        return $this->morphMany(ProviderRule::class, 'roleable');
    }

    public function suggestions() {
        return $this->morphMany(Suggestion::class, 'senderable');
    }

    public function coupons() {
        return $this->morphMany(ProviderStoreCoupon::class, 'userable');
    }

    public function getPrefixAttribute(){
        return 'lab';
    }

    public function setCountryCodeAttribute($value) {
        if (!empty($value)) {
            $this->attributes['country_code'] = fixPhone($value);
        }
    }

    public function getFullPhoneAttribute() {
        return $this->attributes['country_code'] . $this->attributes['phone'];
    }

    public function setPasswordAttribute($value) {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getImageAttribute() {
        if ($this->attributes['image'] && File::exists(public_path('storage/images/' . static::IMAGEPATH . '/' . $this->attributes['image']))) {
            $image = $this->getImage($this->attributes['image'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage(static::IMAGEPATH);
        }
        return $image;
    }

    public function setImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], 'labs') : '';
                $this->attributes['image'] = $this->uploadAllTyps($value, 'labs');
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function logout() {
        if (request()->device_id) {
            $this->devices()->where(['device_id' => request()->device_id])->delete();
        }
        auth('lab')->logout();
        return true;
    }

    public function devices() {
        return $this->morphMany(Device::class, 'morph');
    }

    public function reports() {
        return $this->morphMany(ReportRate::class, 'reportable');
    }

    public function getIdentityImageAttribute() {
        if ($this->attributes['identity_image']) {
            $image = $this->getImage($this->attributes['identity_image'], 'labs');
        } else {
            $image = $this->defaultImage('identity.png');
        }
        return $image;
    }

    public function setIdentityImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['identity_image']) ? $this->deleteFile($this->attributes['identity_image'], 'labs') : '';
                $this->attributes['identity_image'] = $this->uploadeImage($value, 'labs');
            } else {
                $this->attributes['identity_image'] = $value;
            }
        }
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
    public function timings() {
        return $this->hasMany(LabBranchDates::class);
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'lab_id', 'id');
    }

    public function carts() {
        return $this->hasMany(Cart::class, 'lab_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'lab_id');
    }

    private function phoneActivationCode() {
        return 123456;
        return mt_rand(111111, 999999);
    }

    public function sendPhoneActivationCode() {
        $phone_activation_code = $this->phoneActivationCode();

        $this->update([
            'code' => $phone_activation_code,
        ]);
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
