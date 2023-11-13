<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabPermit extends Model
{
    use HasFactory, UploadTrait;
    protected $guarded = [];

    public function setImageAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['image']) ? $this->deleteFile($this->attributes['image'], 'stores') : '';
                $this->attributes['image'] = $this->uploadeImage($value, 'permits');
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getImageAttribute() {
        if ($this->attributes['image']) {
            $image = $this->getImage($this->attributes['image'], 'permits');
        } else {
            $image = $this->defaultImage('permits');
        }
        return $image;
    }

    public function setFileAttribute($value) {
        if (null != $value) {
            if (is_file($value)) {
                isset($this->attributes['file']) ? $this->deleteFile($this->attributes['file'], 'permits') : '';
                $this->attributes['file'] = $this->uploadFile($value, 'permits');
            } else {
                $this->attributes['file'] = $value;
            }
        }
    }

    public function getFileAttribute() {
        if ($this->attributes['file']) {
            $file = $this->getFile($this->attributes['file'], 'permits');
        } else {
            $file = $this->defaultImage('permits');
        }
        return $file;
    }
}
