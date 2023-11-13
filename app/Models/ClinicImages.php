<?php

namespace App\Models;
use App\Traits\UploadTrait;

class ClinicImages extends BaseModel {
    use UploadTrait;
    const IMAGEPATH = 'clinicimages';

    protected $fillable = ['image', 'clinic_id'];

    public function clinic() {
        return $this->belongsTo(Clinics::class);
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

}
