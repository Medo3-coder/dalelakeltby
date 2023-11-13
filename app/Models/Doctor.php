<?php

namespace App\Models;

use App\Traits\SmsTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable {
    use HasFactory, Notifiable, UploadTrait, HasApiTokens, SmsTrait, SoftDeletes;
    const IMAGEPATH = 'doctors';
    const FILES     = [
        'image',
        'identity_image',
        'graduation_certification_image',
        'graduation_certification_pdf',
        'practice_certification_image',
        'practice_certification_pdf',
        'experience_certification_image',
        'experience_certification_pdf',
    ];
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'nickname',
        'address',
        'qualifications',
        'age',
        'phone',
        'examination_price',
        'country_code',
        'identity_number',
        'identity_image',
        'graduation_certification_image',
        'graduation_certification_pdf',
        'practice_certification_image',
        'practice_certification_pdf',
        'experience_certification_image',
        'experience_certification_pdf',
        'experience_years',
        'is_blocked',
        'is_active',
        'is_approved',
        'code',
        'category_id',
        'average_rate',
        'count_rate',
        'city_id',
        'provider_rule_id',
        'parent_id',
        'role_name',
        'abstract',
    ];

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function clinics() {
        return $this->hasMany(Clinics::class, 'doctor_id', 'id')->withTrashed();
    }

    public function branches() {
        return $this->hasMany(Clinics::class)->withTrashed();
    }

    public function permits() {
        return $this->hasMany(DoctorPermit::class, 'doctor_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withTrashed();
    }

    public function ragites() {
        return $this->hasMany(Ragite::class)->withTrashed();
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id')->withTrashed();
    }

    public function medicines() { // withTrashed show the deleted medicines at doctor dashboard
        return $this->hasMany(DoctorMedicine::class, 'doctor_id');
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id')->withTrashed();
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

    public function logout() {
        if (request()->device_id) {
            $this->devices()->where(['device_id' => request()->device_id])->delete();
        }
        auth('doctor')->logout();
        return true;
    }

    public function devices() {
        return $this->morphMany(Device::class, 'morph');
    }

    public function getGraduationCertificationImageAttribute() {
        if ($this->attributes['graduation_certification_image']) {
            $image = $this->getImage($this->attributes['graduation_certification_image'], 'doctors');
        } else {
            $image = $this->defaultImage('doctors');
        }
        return $image;
    }

    public function setGraduationCertificationImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['graduation_certification_image']) ? $this->deleteFile($this->attributes['graduation_certification_image'], 'doctors') : '';
                $this->attributes['graduation_certification_image'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['graduation_certification_image'] = $value;
            }
        }
    }

    public function getPracticeCertificationImageAttribute() {
        if ($this->attributes['practice_certification_image']) {
            $image = $this->getImage($this->attributes['practice_certification_image'], 'doctors');
        } else {
            $image = $this->defaultImage('doctors');
        }
        return $image;
    }

    public function setPracticeCertificationImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['practice_certification_image']) ? $this->deleteFile($this->attributes['practice_certification_image'], 'doctors') : '';
                $this->attributes['practice_certification_image'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['practice_certification_image'] = $value;
            }
        }
    }

    public function getExperienceCertificationImageAttribute() {
        if ($this->attributes['experience_certification_image']) {
            $image = $this->getImage($this->attributes['experience_certification_image'], 'doctors');
        } else {
            $image = $this->defaultImage('doctors');
        }
        return $image;
    }

    public function setExperienceCertificationImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['experience_certification_image']) ? $this->deleteFile($this->attributes['experience_certification_image'], 'doctors') : '';
                $this->attributes['experience_certification_image'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['experience_certification_image'] = $value;
            }
        }
    }

    public function getImageAttribute() {
        if ($this->attributes['image']) {
            $image = $this->getImage($this->attributes['image'], 'doctors');
        } else {
            $image = $this->defaultImage('doctors');
        }
        return $image;
    }

    public function setImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], 'doctors') : '';
                $this->attributes['image'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getIdentityImageAttribute() {
        if ($this->attributes['identity_image']) {
            $image = $this->getImage($this->attributes['identity_image'], 'doctors');
        } else {
            $image = $this->defaultImage('doctors');
        }
        return $image;
    }

    public function setIdentityImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['identity_image']) ? $this->deleteFile($this->attributes['identity_image'], 'doctors') : '';
                $this->attributes['identity_image'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['identity_image'] = $value;
            }
        }
    }

    public function getGraduationCertificationPdfAttribute() {
        return $this->attributes['graduation_certification_pdf'] ? asset('storage/images/doctors/' . $this->attributes['graduation_certification_pdf']) : '';
    }

    public function setGraduationCertificationPdfAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['graduation_certification_pdf']) ? $this->deleteFile($this->attributes['graduation_certification_pdf'], 'doctors') : '';
                $this->attributes['graduation_certification_pdf'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['graduation_certification_pdf'] = $value;
            }
        }

    }

    public function getPracticeCertificationPdfAttribute() {
        return $this->attributes['practice_certification_pdf'] ? asset('storage/images/doctors/' . $this->attributes['practice_certification_pdf']) : '';
    }

    public function setPracticeCertificationPdfAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['practice_certification_pdf']) ? $this->deleteFile($this->attributes['practice_certification_pdf'], 'doctors') : '';
                $this->attributes['practice_certification_pdf'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['practice_certification_pdf'] = $value;
            }
        }
    }

    public function getExperienceCertificationPdfAttribute() {
        return $this->attributes['experience_certification_pdf'] ? asset('storage/images/doctors/' . $this->attributes['experience_certification_pdf']) : '';
    }

    public function setExperienceCertificationPdfAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['experience_certification_pdf']) ? $this->deleteFile($this->attributes['experience_certification_pdf'], 'doctors') : '';
                $this->attributes['experience_certification_pdf'] = $this->uploadAllTyps($value, 'doctors');
            } else {
                $this->attributes['experience_certification_pdf'] = $value;
            }
        }
    }

    public function scopeSearch($query, $searchArray = []) {
        $query->where(function ($query) use ($searchArray) {
            if ($searchArray) {
                foreach ($searchArray as $key => $value) {
                    // for search with city
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

    public function scopeAppFilter($query, $searchArray = []) {
        $query->where(function ($query) use ($searchArray) {
            if ($searchArray) {
                foreach ($searchArray as $key => $value) {
                    if (str_contains($key, '_id')) {
                        if (null != $value) {
                            $query->Where($key, $value);
                        }
                    } elseif ('created_at_min' == $key) {
                        if (null != $value) {
                            $query->WhereDate('created_at', '>=', $value);
                        }
                    } elseif ('created_at_max' == $key) {
                        if (null != $value) {
                            $query->WhereDate('created_at', '<=', $value);
                        }

                    } elseif ('keyword' == $key) {
                        if (null != $value) {
                            $query->Where('name', 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        });
        return $query->where(['is_active' => 1, 'is_blocked' => 0, 'is_approved' => 'accepted'])->orderBy('id', 'DESC');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'doctor_id');
    }

    // public function rules() {
    //     return $this->belongsToMany(ProviderRule::class, 'doctor_rules', 'doctor_id', 'provider_rule_id');
    // }

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

    public function reports() {
        return $this->morphMany(ReportRate::class, 'reportable');
    }

    public function getPrefixAttribute(){
        return 'doctor';
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
