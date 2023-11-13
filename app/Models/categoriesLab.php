<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoriesLab extends Model {
    use HasFactory;

    protected $fillable = [
        'category_id',
        'lab_id',
    ];

    public function labCategory() {
        return $this->belongsTo(LabCategory::class, 'lab_category_id')->withTrashed();
    }

    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id')->withTrashed();
    }
}
