<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Ragite extends BaseModel
{
    use SoftDeletes;
    const IMAGEPATH = 'ragites';

    protected $fillable = ['image', 'doctor_id'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class , 'doctor_id', 'id');
    }

}
