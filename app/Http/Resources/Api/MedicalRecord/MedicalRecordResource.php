<?php

namespace App\Http\Resources\Api\MedicalRecord;

use App\Http\Resources\Api\MedicalRecord\MedicalRecordMedicanResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'id'             => $this->id,
            'status'         => $this->status_text,
            'patient'        => $this->reservation_for == 'family' ? [
                'name' => $this->patient_name,
                'age'  => $this->patient_age,
            ] : [
                'name' => $this->user->name,
                'age'  => $this->user->age,
            ],
            'date'           => Carbon::parse($this->date)->isoFormat('D-M-YYYY'),
            'doctor'         => [
                'id'         => $this->doctor->id,
                'name'       => $this->doctor->name,
                'speciality' => $this->doctor->category->name,
                'address'    => $this->doctor->address,
                'phone'      => $this->doctor->full_phone,
            ],
            // 'ragite'         => [
            //     'id'    => $this->MedicalRecord->ragite_id,
            //     'image' => $this->MedicalRecord->ragite->image,
            // ],
            'medicines'      => $this->MedicalRecord ? MedicalRecordMedicanResource::collection($this->MedicalRecord->medicalRecordMedicans) : null,
            'next_medicines' => $this->MedicalRecord ? new MedicalRecordMedicanResource($this->MedicalRecord->medicalRecordMedicans()->orderBy('next_time')->first()) : null,
            'start_receipt'  => $this->MedicalRecord ? $this->MedicalRecord->start_receipt : null,
            'images'         => count($this->images) > 0 ? $this->images()->select('id', 'type', 'image')->get() : null,
        ];
    }
}
