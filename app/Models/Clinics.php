<?php

namespace App\Models;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinics extends BaseModel {
    use UploadTrait,SoftDeletes;

    protected $fillable = ['lat', 'lng', 'name', 'address', 'address_map', 'comerical_record', 'detection_price', 'doctor_id'];

    public function doctor() {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function images() {
        return $this->hasMany(ClinicImages::class, 'clinic_id', 'id');
    }
    public function dates() {
        return $this->hasMany(ClinicDate::class, 'clinic_id', 'id');
    }

    // public function clinicImages()
    // {
    //     return $this->hasMany(ClinicImages::class);
    // }

}
