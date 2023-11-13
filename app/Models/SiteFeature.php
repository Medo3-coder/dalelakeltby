<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class SiteFeature extends BaseModel
{
    const IMAGEPATH = 'sitefeatures' ; 

    use HasTranslations; 
    protected $fillable = ['title','description' ,'image'];
    public $translatable = ['title','description'];

}
