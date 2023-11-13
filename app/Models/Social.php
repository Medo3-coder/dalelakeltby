<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\File;

class Social extends BaseModel
{
    use UploadTrait;

    const IMAGEPATH = 'socials' ; 
    protected $fillable = ['link' , 'icon' , 'name'];

    public function getIconAttribute() {
        if ($this->attributes['icon'] && File::exists(public_path('storage/images/' . static::IMAGEPATH . '/' . $this->attributes['icon'] ))) {
            $image = $this->getImage($this->attributes['icon'], static::IMAGEPATH);
        } else {
            $image = $this->defaultImage(static::IMAGEPATH);
        }
        return $image;
    }

    public function setIconAttribute($value) {
        if (null != $value && is_file($value) ) {
            isset($this->attributes['icon']) ? $this->deleteFile($this->attributes['icon'] , static::IMAGEPATH) : '';
            $this->attributes['icon'] = $this->uploadAllTyps($value, static::IMAGEPATH);
        }
    }
        
}
