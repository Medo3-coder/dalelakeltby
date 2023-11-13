<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends BaseModel {
    const IMAGEPATH = 'reservations';

    use SoftDeletes;

    protected $fillable = [
        'parent_id', 'lab_report',
        'user_id', 'doctor_id', 'clinic_id', 'lat', 'lng', 'reservation_for', 'date', 'time',
        'details', 'reservation_price', 'detection_price', 'admin_commission_ratio', 'admin_commission_amount',
        'vat_rate_ratio', 'vat_rate_amount', 'total_price', 'final_total', 'paient_name', 'paient_blood_type_id',
        'paient_age', 'paient_weight', 'paient_height', 'paient_gender', 'status', 'rate', 'comment', 'payment_status', 'payment_method', 'cancel_reason',
        'lab_branch_id', 'lab_id', 'lab_category_id', 'analysis_price', 'cancel_reason_id', 'type',
    ];

    protected $casts = [
        'lat'  => 'decimal:8',
        'lng'  => 'decimal:8',
        'date' => 'date',
    ];

    public function getReservationTimeAttribute() {
        return Carbon::parse($this->attributes['time'])->isoFormat('h:m a');
    }
    public function getReservationDateAttribute() {
        return Carbon::parse($this->attributes['date'])->isoFormat('D/M/YYYY');
    }

    public function setDateAttribute($value) {
        $this->attributes['date'] = Carbon::parse($value)->isoFormat('YYYY-M-D');
    }

    public function getNameAttribute() {
        return $this->attributes['reservation_for'] == 'same_person' ? $this->user->name : $this->attributes['paient_name'];
    }

    public function getAgeAttribute() {
        return $this->attributes['reservation_for'] == 'same_person' ? $this->user->age : $this->attributes['paient_age'];
    }

    public function getWeightAttribute() {
        return $this->attributes['reservation_for'] == 'same_person' ? $this->user->weight : $this->attributes['paient_weight'];
    }

    public function getHeightAttribute() {
        return $this->attributes['reservation_for'] == 'same_person' ? $this->user->height : $this->attributes['paient_height'];
    }

    public function getGenderAttribute() {
        return $this->attributes['reservation_for'] == 'same_person' ? $this->user->gender : $this->attributes['paient_gender'];
    }

    public function images() {
        return $this->hasMany(ReservationImage::class, 'reservation_id', 'id');
    }

    public function MedicalRecord() {
        return $this->hasOne(MedicalRecord::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withTrashed();
    }
    public function clinic() {
        return $this->belongsTo(Clinics::class, 'clinic_id', 'id')->withTrashed();
    }

    public function getStatusTextAttribute($value) {
        return __('apis.status_' . $this->attributes['status']);
    }

    public function labSubCategories() {
        return $this->belongsToMany(SubCategoryLab::class, 'lab_subcategory_reservations', 'reservation_id', 'sub_category_lab_id')->withTrashed();
    }

    public function labBranch() {
        return $this->belongsTo(LabBranch::class, 'lab_branch_id')->withTrashed();
    }

    public function labCategory() {
        return $this->belongsTo(LabCategory::class, 'lab_category_id')->withTrashed();
    }
    public function lab() {
        return $this->belongsTo(Lab::class, 'lab_id', 'id')->withTrashed();
    }

    public function cancelReason() {
        return $this->belongsTo(CancelReason::class, 'cancel_reason_id')->withTrashed();
    }

    public function patientBloodType() {
        return $this->belongsTo(BloodType::class, 'paient_blood_type_id')->withTrashed();
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id')->withTrashed();
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id')->withTrashed();
    }

    // public function test() {
    //     return $this->hasOne(self::class, 'parent_id');
    // }

    //  this is the required tests and the result of every test
    public function labSubcategoryReservationHasMany() {
        return $this->hasMany(LabSubcategoryReservation::class, 'reservation_id');
    }

}
