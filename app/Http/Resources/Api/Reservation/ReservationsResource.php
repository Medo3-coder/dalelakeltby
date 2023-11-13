<?php

namespace App\Http\Resources\Api\Reservation;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'time'               => date('h:i A', strtotime($this->time)),
            'date'               => $this->date->format('d-m-Y'),
            'status_text'        => $this->status_text,
            'currency'           => __('site.currency'),
            'type'               => $this->doctor_id ? 'doctor' : 'lab' ,
            'doctor'             => $this->doctor_id ? [
                'id'                 => $this->doctor_id,
                'reservation_price'  => $this->reservation_price,
                'name'               => $this->doctor->name,
                'specialty'          => $this->doctor->category->name,
                'city'               => $this->doctor->city->name,
                'rate'               => $this->doctor->average_rate,
                'image'              => $this->doctor->image,
            ] : null,
            'lab'               => $this->lab_id ? [
                'id'        => $this->lab_id,
                'name'      => $this->lab->name,
                'city'      => $this->lab->city->name,
                'rate'      => $this->lab->rate_avg,
                'image'     => $this->lab->image,
            ] : null,

        ];
    }
}
