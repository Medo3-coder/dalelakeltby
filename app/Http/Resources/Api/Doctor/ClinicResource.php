<?php

namespace App\Http\Resources\Api\Doctor;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource {
    public function toArray($request) {
        return [
            'id'              => $this->id,
            'lat'             => $this->lat,
            'lng'             => $this->lng,
            'name'            => $this->name,
            'address'         => $this->address,
            'detection_price' => $this->detection_price,
            'currency'        => __('site.currency'),
            'images'          => $this->images->pluck('image')->toArray(),
            'dates'           => $this->dates->map(function ($date) {
                return [
//                    'day'  => getFullDay($date->day),
                    'day'  => __('localize.' . strtolower($date->day) ),

                    'from' => Carbon::parse($date->from)->isoFormat('h:m a'),
                    'to'   => Carbon::parse($date->to)->isoFormat('h:m a'),
                ];
            }),
        ];
    }
}
