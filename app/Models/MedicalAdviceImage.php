<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalAdviceImage extends BaseModel {
    use HasFactory;
    const IMAGEPATH = 'medicaladviceimages';

    protected $fillable = [
        'image',
        'medical_advice_id',
    ];

    public function medicalAdvice(){
        return $this->belongsTo(MedicalAdvice::class ,'medical_advice_id');
    }
}
