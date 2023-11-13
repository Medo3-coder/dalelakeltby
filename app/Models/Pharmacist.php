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

class Pharmacist extends Authenticatable {
    const IMAGEPATH = 'pharmacists';
    use HasFactory, Notifiable, UploadTrait, HasApiTokens, SmsTrait, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'age', 'phone', 'country_code', 'code', 'identity_number', 'identity_image',
        'graduation_certification_image', 'experience_certification_image', 'count_rate', "parent_id", 'role_name',
        'graduation_certification_pdf', 'practice_certification_image', 'practice_certification_pdf',
        'experience_certification_pdf', 'experience_years', 'is_blocked', 'is_active', 'is_approved', 'average_rate',
    ];

    public function branches() {
        return $this->hasMany(PharmacyBranch::class)->withTrashed();
    }

    public function firstBranch() {
        return $this->branches()->first();
    }

    public function setPasswordAttribute($value) {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function getGraduationCertificationImageAttribute() {
        if ($this->attributes['graduation_certification_image']) {
            $image = $this->getImage($this->attributes['graduation_certification_image'], 'pharmacists');
        } else {
            $image = $this->defaultImage('pharmacists');
        }
        return $image;
    }

    public function setGraduationCertificationImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['graduation_certification_image']) ? $this->deleteFile($this->attributes['graduation_certification_image'], 'pharmacists') : '';
                $this->attributes['graduation_certification_image'] = $this->uploadeImage($value, 'pharmacists');
            } else {
                $this->attributes['graduation_certification_image'] = $value;
            }
        }
    }

    public function getPracticeCertificationImageAttribute() {
        if ($this->attributes['practice_certification_image']) {
            $image = $this->getImage($this->attributes['practice_certification_image'], 'pharmacists');
        } else {
            $image = $this->defaultImage('pharmacists');
        }
        return $image;
    }

    public function setPracticeCertificationImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['practice_certification_image']) ? $this->deleteFile($this->attributes['practice_certification_image'], 'pharmacists') : '';
                $this->attributes['practice_certification_image'] = $this->uploadeImage($value, 'pharmacists');
            } else {
                $this->attributes['practice_certification_image'] = $value;
            }
        }
    }

    public function getExperienceCertificationImageAttribute() {
        if ($this->attributes['experience_certification_image']) {
            $image = $this->getImage($this->attributes['experience_certification_image'], 'pharmacists');
        } else {
            $image = $this->defaultImage('pharmacists');
        }
        return $image;
    }

    public function setExperienceCertificationImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['experience_certification_image']) ? $this->deleteFile($this->attributes['experience_certification_image'], 'pharmacists') : '';
                $this->attributes['experience_certification_image'] = $this->uploadeImage($value, 'pharmacists');
            } else {
                $this->attributes['experience_certification_image'] = $value;
            }
        }
    }

    public function permits() {
        return $this->hasMany(PharmacyPermit::class, 'pharmacy_id');
    }

    public function getImageAttribute() {
        if ($this->attributes['image'] && File::exists(public_path('storage/images/' . static::IMAGEPATH . '/' . $this->attributes['image']))) {
            $image = $this->getImage($this->attributes['image'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage(static::IMAGEPATH);
        }
        return $image;
    }

    public function getFullPhoneAttribute() {
        return $this->attributes['country_code'] . $this->attributes['phone'];
    }

    public function setImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], 'pharmacists') : '';
                $this->attributes['image'] = $this->uploadeImage($value, 'pharmacists');
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getIdentityImageAttribute() {
        if ($this->attributes['identity_image']) {
            $image = $this->getImage($this->attributes['identity_image'], 'pharmacists');
        } else {
            $image = $this->defaultImage('pharmacists');
        }
        return $image;
    }

    public function setIdentityImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['identity_image']) ? $this->deleteFile($this->attributes['identity_image'], 'pharmacists') : '';
                $this->attributes['identity_image'] = $this->uploadeImage($value, 'pharmacists');
            } else {
                $this->attributes['identity_image'] = $value;
            }
        }
    }

    public function getGraduationCertificationPdfAttribute() {
        return $this->attributes['graduation_certification_pdf'] ? asset('storage/images/pharmacists/' . $this->attributes['graduation_certification_pdf']) : '';
    }

    public function setGraduationCertificationPdfAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['graduation_certification_pdf']) ? $this->deleteFile($this->attributes['graduation_certification_pdf'], 'pharmacists') : '';
                $this->attributes['graduation_certification_pdf'] = $this->uploadAllTyps($value, 'pharmacists');
            } else {
                $this->attributes['graduation_certification_pdf'] = $value;
            }
        }

    }

    public function getPrefixAttribute(){
        return 'pharmacy';
    }

    public function getPracticeCertificationPdfAttribute() {
        return $this->attributes['practice_certification_pdf'] ? asset('storage/images/pharmacists/' . $this->attributes['practice_certification_pdf']) : '';
    }

    public function setPracticeCertificationPdfAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['practice_certification_pdf']) ? $this->deleteFile($this->attributes['practice_certification_pdf'], 'pharmacists') : '';
                $this->attributes['practice_certification_pdf'] = $this->uploadAllTyps($value, 'pharmacists');
            } else {
                $this->attributes['practice_certification_pdf'] = $value;
            }
        }
    }

    public function getExperienceCertificationPdfAttribute() {
        return $this->attributes['experience_certification_pdf'] ? asset('storage/images/pharmacists/' . $this->attributes['experience_certification_pdf']) : '';
    }

    public function setExperienceCertificationPdfAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['experience_certification_pdf']) ? $this->deleteFile($this->attributes['experience_certification_pdf'], 'pharmacists') : '';
                $this->attributes['experience_certification_pdf'] = $this->uploadAllTyps($value, 'pharmacists');
            } else {
                $this->attributes['experience_certification_pdf'] = $value;
            }
        }
    }

    public function logout() {
        if (request()->device_id) {
            $this->devices()->where(['device_id' => request()->device_id])->delete();
        }
        auth('pharmacy')->logout();
        return true;
    }

    public function devices() {
        return $this->morphMany(Device::class, 'morph');
    }

    public function coupons() {
        return $this->morphMany(ProviderStoreCoupon::class, 'userable');
    }

    public function orders(){
        return $this->hasMany(Order::class ,'pharmacist_id');
    }

    public function scopeMainCategories($query) {
        return $query->where('parent_id', null);
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function subChildes() {
        return $this->childes()->with('subChildes');
    }

    public function subParents() {
        return $this->parent()->with('subParents');
    }

    public function carts() {
        return $this->hasMany(Cart::class, 'pharmacy_id');
    }

    public function cartProductOffers() {
        return $this->hasManyThrough(CartOfferProduct::class, Cart::class, 'pharmacy_id');
    }

    public function getAllChildren() {
        $sections = new Collection();
        foreach ($this->childes as $section) {
            $sections->push($section);
            $sections = $sections->merge($section->getAllChildren());
        }
        return $sections;
    }

    public function getAllParents() {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function roles() {
        return $this->morphMany(ProviderRule::class, 'roleable');
    }

    public function suggestions() {
        return $this->morphMany(Suggestion::class, 'senderable');
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

}
