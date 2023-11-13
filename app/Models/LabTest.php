<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTest extends BaseModel {
    use HasFactory;

    protected $fillable = [
        'sub_category_lab_id',
        'name',
        'price',
        'normal_range',
        'unit',
    ];

    public function subCategoryLab() {
        return $this->belongsTo(SubCategoryLab::class, 'sub_category_lab_id');
    }
}
