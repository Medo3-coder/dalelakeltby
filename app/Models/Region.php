<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Region extends BaseModel
{
    const IMAGEPATH = 'regions' ; 

    use HasTranslations; 

    protected $fillable = ['name','country_id'];

    public $translatable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'region_id', 'id');
    }

}
