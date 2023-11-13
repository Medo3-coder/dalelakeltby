<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class TargetBodyArea extends BaseModel {

    use HasTranslations, SoftDeletes;
    protected $fillable  = ['name'];
    public $translatable = ['name'];

    public function ScanTagetBody() {
        return $this->hasMany(LabScanTagetBody::class);
    }

    public function subCategoriesLabs() {
        return $this->belongsToMany(SubCategoryLab::class, 'sub_categories_labs_targeted_bodies', 'target_body_id', 'sub_category_lab_id');
    }
}
