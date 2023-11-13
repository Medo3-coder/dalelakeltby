<?php

namespace App\Http\Resources\Api\MedicalRecord;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordsResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'id'     => $this->id,
            'status' => $this->status_text,
            'doctor' => [
                'id'         => $this->doctor->id,
                'image'      => $this->doctor->image,
                'name'       => $this->doctor->name,
                'speciality' => $this->doctor->category->name,
                'rate'       => $this->doctor->average_rate,
                'city'       => $this->doctor->city->name,
            ],
        ];
    }
}
