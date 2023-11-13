<?php

namespace App\Http\Resources\Api\MedicalRecord;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MedicalRecordMedicanResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'id'                    => $this->id,
            'medicine_name'         => $this->doctorMedicine->name,
            'times'                 => $this->times,
            'hours'                 => $this->hours,
            'next_time'             => Carbon::parse($this->next_time)->diffForHumans(),
            'next_time_in_minutes'  => Carbon::parse($this->next_time)->isPast() ? 0 : Carbon::now()->diffInMinutes($this->next_time),
        ];
    }
}
