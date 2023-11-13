<?php

namespace App\Http\Resources\Api\MedicalAdvices;

use App\Traits\PaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Api\MedicalAdvices\MedicalAdvicesResource;

class MedicalAdvicesCollection extends ResourceCollection
{
    use PaginationTrait;
    public function toArray($request)
    {
        return [
            'pagination' => $this->paginationModel($this),
            'data'       => MedicalAdvicesResource::collection($this->collection),
        ];
    }
}
