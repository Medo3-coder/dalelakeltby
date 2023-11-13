<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorMedicine extends BaseModel {
    const IMAGEPATH = 'doctormedicine';

    use SoftDeletes;

    protected $fillable = ['type', 'name', 'image', 'doctor_id'];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecordMedicines() {
        return $this->hasMany(MedicalRecordMedican::class, 'doctor_medican_id');
    }

    public function clinic() {
        return $this->belongsTo(Doctor::class);
    }
}
