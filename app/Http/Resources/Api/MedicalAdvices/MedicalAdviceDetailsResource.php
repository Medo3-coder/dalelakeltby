<?php

namespace App\Http\Resources\Api\MedicalAdvices;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalAdviceDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'images'      => $this->images->pluck('image')->toArray(),
            'title'       => $this->title,
            'description' => $this->description,
            'created_at'  => getDay($this->created_at->format('D')).' ' . $this->created_at->format('d/m/y'),
        ];
    }
}
