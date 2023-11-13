<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabSubcategoryReservation extends Model {
    use HasFactory;

    protected $fillable = ['sub_category_lab_id', 'reservation_id' ,'result'];

    public function subCategoryLab() {
        return $this->belongsTo(SubCategoryLab::class, 'sub_category_lab_id');
    }

    public function reservation() {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
