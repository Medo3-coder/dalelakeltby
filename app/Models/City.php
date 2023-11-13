<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends BaseModel
{
    use HasTranslations,SoftDeletes; 
    
    protected $fillable = ['name', 'country_id'];
    
    public $translatable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    
    
}
