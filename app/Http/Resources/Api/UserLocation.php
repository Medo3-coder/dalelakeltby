<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLocation extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id ,
            'title'   => $this->title ,
            'lat'     => $this->lat ,
            'lng'     => $this->lng ,
            'address' => $this->address ,
        ];
    }
}
