<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoryLab extends Model {
    use HasFactory,SoftDeletes;

    protected $fillable = ['lab_id', 'lab_category_id', 'sub_category_id', 'price', 'name', 'unit', 'normal_range'];

    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    public function labCategory() {
        return $this->belongsTo(LabCategory::class, 'lab_category_id');
    }

    public function labSubCategory() {
        return $this->belongsTo(LabCategory::class, 'sub_category_id');
    }

    public function targetedBodyAreas() {
        return $this->belongsToMany(TargetBodyArea::class, 'sub_categories_labs_targeted_bodies', 'sub_category_lab_id', 'target_body_id');
    }

    public function labSubcategoryReservationHasMany() {
        return $this->hasMany(LabSubcategoryReservation::class, 'sub_category_lab_id');
    }

    public function labReservations() {
        return $this->belongsToMany(Reservation::class, 'lab_subcategory_reservations', 'sub_category_lab_id', 'reservation_id');
    }

    public function tests(){
        return $this->hasMany(LabTest::class ,'sub_category_lab_id');
    }
}
