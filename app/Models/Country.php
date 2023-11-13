<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Country extends BaseModel {
    use HasTranslations;

    const IMAGEPATH = 'countries';

    protected $fillable = ['name', 'key', 'image'];

    public $translatable = ['name'];

    public function regions() {
        return $this->hasMany(Region::class, 'country_id', 'id');
    }

    public function cities() {
        return $this->hasMany(City::class, 'country_id');
    }
}
