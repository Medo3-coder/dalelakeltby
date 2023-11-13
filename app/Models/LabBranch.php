<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class LabBranch extends Model {
    const IMAGEPATH = 'labbranch';
    const FILES     = ['opening_certificate_image', 'opening_certificate_pdf'];

    use HasFactory, UploadTrait,SoftDeletes;
    protected $fillable = ['lab_id', 'lat', 'lng', 'name' , 'address','address_map', 'opening_certificate_image' , 'city_id', 'opening_certificate_pdf', 'comerical_record'];

    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    // public function dates(){
    //     return $this->hasMany(LabBranchDate::class );
    // }

    public function dates() {
        return $this->hasMany(LabBranchDate::class);
    }

    public function images() {
        return $this->hasMany(LabBranchImage::class);
    }

    public function getOpeningCertificateImageAttribute() {
        if ($this->attributes['opening_certificate_image']) {
            $image = $this->getImage($this->attributes['opening_certificate_image'], 'labbranch');
        } else {
            $image = $this->defaultImage('opening.jpg');
        }
        return $image;
    }

    public function setOpeningCertificateImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['opening_certificate_image']) ? $this->deleteFile($this->attributes['opening_certificate_image'], 'labbranch') : '';
                $this->attributes['opening_certificate_image'] = $this->uploadeImage($value, 'labbranch');
            } else {
                $this->attributes['opening_certificate_image'] = $value;
            }
        }
    }

    public function getOpeningCertificatePdfAttribute() {
        return $this->attributes['opening_certificate_pdf'] ? asset('storage/images/labbranch/files/' . $this->attributes['opening_certificate_pdf']) : '';
    }

    public function setOpeningCertificatePdfAttribute($value) {
        if ($value != null) {
            if (is_file($value)) {
                isset($this->attributes['opening_certificate_pdf']) ? File::delete(public_path('storage/labbranch/files/' . $this->attributes['opening_certificate_pdf'])) : '';
                $this->attributes['opening_certificate_pdf'] = $this->uploadAllTyps($value, 'labbranch/files', true, 250, null);
            } else {
                $this->attributes['opening_certificate_pdf'] = $value;
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

    public function reservations(){
        return $this->hasMany(Reservation::class ,'lab_branch_id');
    }

    public function city(){
        return $this->belongsTo(City::class ,'city_id');
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
