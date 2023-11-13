<?php

namespace App\Http\Resources\Api\Lab;

use Illuminate\Http\Resources\Json\JsonResource;

class LabResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'image'               => $this->image,
        ];
    }
}
