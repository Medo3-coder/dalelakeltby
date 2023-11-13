<?php

namespace App\Http\Resources\Api\Reservation;

use App\Traits\PaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Api\Reservation\ReservationsResource;

class ReservationCollection extends ResourceCollection
{
    use PaginationTrait;

    public function toArray($request)
    {
        return [
            'pagination' => $this->paginationModel($this),
            'data'       => ReservationsResource::collection($this->collection),
        ];
    }
}
