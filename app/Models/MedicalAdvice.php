<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class MedicalAdvice extends BaseModel {
    const IMAGEPATH = 'medicaladvices';

    use HasTranslations;
    protected $fillable  = ['title', 'description'];
    public $translatable = ['title', 'description'];

    public function images() {
        return $this->hasMany(MedicalAdviceImage::class, 'medical_advice_id');
    }

    public function getImageAttribute() {
        return $this->images()->first()->image;
    }
}
