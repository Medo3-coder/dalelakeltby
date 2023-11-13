<?php

namespace App\Http\Resources\Api\MedicalAdvices;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalAdvicesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id    ,
            'image'       => $this->image ,
            'title'       => $this->title ,
            'description' => $this->description ,
        ];
    }
}
