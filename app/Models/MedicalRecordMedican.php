<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordMedican extends Model
{
    use HasFactory;
    protected $fillable = ['medical_record_id','doctor_medican_id','hours','times','reservation_id' ,'next_time'];


    public function reservation()
    {
        return $this->belongsTo(Reservation::class)->withTrashed();
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class)->withTrashed();
    }


    public function doctorMedicine(){
        return $this->belongsTo(DoctorMedicine::class ,'doctor_medican_id')->withTrashed();
    }
    
}
