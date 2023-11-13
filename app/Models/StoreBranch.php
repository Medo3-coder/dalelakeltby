<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class StoreBranch extends Model {
    const IMAGEPATH = 'storebranch';
    use HasFactory, UploadTrait,SoftDeletes;
    protected $fillable = ['store_id', 'name', 'lat', 'lng', 'address', 'address_map', 'opening_certificate_image', 'opening_certificate_pdf', 'comerical_record'];

    const FILES = [
        'opening_certificate_image',
        'opening_certificate_pdf',
    ];

    public function dates() {
        return $this->hasMany(StoreDate::class);
    }

    public function images() {
        return $this->hasMany(StoreBranchImage::class);
    }

    public function eligibles()
    {
        return $this->hasMany(StoreEligible::class, 'store_branches_id');
    }

    public function getOpeningCertificateImageAttribute() {
        if ($this->attributes['opening_certificate_image']) {
            $image = $this->getImage($this->attributes['opening_certificate_image'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage('opening.jpg');
        }
        return $image;
    }

    public function setOpeningCertificateImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['opening_certificate_image']) ? $this->deleteFile($this->attributes['opening_certificate_image'], static::IMAGEPATH) : '';
                $this->attributes['opening_certificate_image'] = $this->uploadeImage($value, static::IMAGEPATH);
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
