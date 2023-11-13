<?php

namespace App\Http\Resources\Api\Lab;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LabBranchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id       , 
            'name'           => $this->name     , 
            'lat'            => $this->lat      , 
            'lng'            => $this->lng      ,
            'address'        => $this->address ,
            'images'         => $this->images->pluck('image')->toArray() ,
            'dates'             => $this->dates->map(function ($date) {
                return [
                    'day'       => $date->day,
                    'from'      => Carbon::parse($date->from)->format('h:iA'),
                    'to'        => Carbon::parse($date->to)->format('h:iA'),
                ];
            }),
        ];
    }
}
