<?php

namespace App\Http\Resources\Api\Reservation;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\MedicalRecord\MedicalRecordMedicanResource;

class ReservationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                 => $this->id                ,
            'currency'           => __('site.currency'),
            'date'               => $this->date->format('d-m-Y')              ,
            'time'               => date('h:iA', strtotime($this->time))              ,
            'details'            => $this->details ,
            'doctor'             => $this->doctor_id != null ? [
                'reservation_price'  => $this->reservation_price ,
                'detection_price'    => $this->detection_price   ,
                'id'        => $this->doctor_id               , 
                'name'      => $this->doctor->name            ,
                'speciality' => $this->doctor->category->name ,
                'city'      => $this->doctor->city->name      , 
                'rate'      => $this->doctor->average_rate ,
                'image'     => $this->doctor->image,
            ] : null,
            'clinic'             => $this->clinic_id != null ? [
                'name'      => $this->clinic->address , 
                'lat'       => $this->clinic->lat , 
                'lng'       => $this->clinic->lng , 
                'images'    => $this->clinic->images->map(function($image){ return $image->image ;}) 
            ]: null,
            'lab'               => $this->lab_id ? [
                'analysis_price'        => $this->analysis_price,
                'id'        => $this->lab_id,
                'name'      => $this->lab->name,
                'city'      => $this->lab->city->name,
                'rate'      => $this->lab->rate_avg,
                'image'     => $this->lab->image,
            ] : null,
            'lab_branch'               => $this->lab_branch_id ? [
                'id'        => $this->lab_branch_id,
                'address'      => $this->labBranch->address,
                'lat'      => $this->labBranch->lat,
                'lng'      => $this->labBranch->lng,
                'images'      => $this->labBranch->images->pluck('image'),
            ] : null,
            'sub_categories'   => $this->labSubcategoryReservationHasMany->count() > 0 ? $this->labSubcategoryReservationHasMany->map(function($subCategory){
                return [
                    'id'        => $subCategory->SubCategoryLab->id,
                    'price'     => $subCategory->SubCategoryLab->price,
                    'name'      => $subCategory->SubCategoryLab->labSubCategory->name,
                ] ;
            }) : null,
            'status'         => $this->status      ,
            'type'          => $this->doctor_id == null ? 'lab' : 'doctor',
            'rate'           => $this->rate      ,
            'comment'        => $this->comment      ,
            'status_text'    => $this->status_text ,
            'payment_status' => $this->payment_status ,

            'medicines'         => $this->MedicalRecord ? MedicalRecordMedicanResource::collection($this->MedicalRecord->medicalRecordMedicans) : null,
            'diagnosis'       => $this->MedicalRecord?->diagnosis,
            'chranic_disease' => $this->chranic_disease?->name,
            'images'            => count($this->images) > 0 ? $this->images()->select('id' ,'type' ,'image')->get() : null,
            'reservation_price'=> $this->reservation_price,
            'detection_price'=> $this->detection_price,
        ];
    }
}
