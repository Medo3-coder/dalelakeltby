<?php

namespace App\Models;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreBranchImage extends BaseModel {
    const IMAGEPATH = 'storeimages';
    use HasFactory, UploadTrait;
    protected $fillable = ['image', 'store_id', 'store_branch_id'];


    public function setImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], 'stores') : '';
                $this->attributes['image'] = $this->uploadeImage($value, 'stores');
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getImageAttribute() {
        if ($this->attributes['image']) {
            $image = $this->getImage($this->attributes['image'], 'stores');
        } else {
            $image = $this->defaultImage('stores');
        }
        return $image;
    }

}
