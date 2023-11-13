<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class LabCategory extends BaseModel {

    const IMAGEPATH = 'labs';
    use HasTranslations, SoftDeletes;
    protected $fillable  = ['name', 'has_targeted_body', 'parent_id', 'lab_id', 'image'];
    public $translatable = ['name'];

    public function labs() {
        return $this->belongsToMany(Lab::class, 'categories_labs', 'lab_category_id', 'lab_id')->withTrashed();
    }

    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id')->withTrashed();
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id')->withTrashed();
    }
}
