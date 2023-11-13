<?php

namespace App\Http\Resources\Api\Lab;

use Illuminate\Http\Resources\Json\JsonResource;

class LabCategoryDetails extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"           => $this->id,
            "name"         => $this->labSubCategory->name,
            "price"        => $this->price,
            "currency"     => __('site.currency'),
        ];
    }
}
