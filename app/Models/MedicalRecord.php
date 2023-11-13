<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
class MedicalRecord extends Model
{
    use HasFactory,HasTranslations ,SoftDeletes;
    protected $casts = [
        'start_receipt' => 'boolean'
    ];
    protected $fillable = ['diagnosis' , 'reservation_id','ragite_id','chranic_disease_id' ,'start_receipt'];
    public $translatable = ['diagnosis'];

    public function ragite()
    {
        return $this->belongsTo(Ragite::class);
    }


    public function reservation()
    {
        return $this->belongsTo(Reservation::class)->withTrashed();
    }


    public function disease()
    {
        return $this->belongsTo(ChranicDiseases::class)->withTrashed();
    }

    public function medicalRecordMedicans(){
        return $this->hasMany(MedicalRecordMedican::class ,'medical_record_id');
    }

}
