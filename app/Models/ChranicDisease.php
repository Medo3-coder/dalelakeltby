<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ChranicDisease extends BaseModel
{
    const IMAGEPATH = 'chranicdiseases' ; 

    use HasTranslations ,SoftDeletes; 
    protected $fillable = ['name','image'];
    public $translatable = ['name'];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }



}
