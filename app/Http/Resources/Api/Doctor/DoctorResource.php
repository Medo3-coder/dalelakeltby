<?php

namespace App\Http\Resources\Api\Doctor;

use App\Models\SiteSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource {
    public function toArray($request) {
        return
            [
            'id'                => $this->id,
            'name'              => $this->name,
            'image'             => $this->image,
            'qualifications'    => $this->qualifications,
            'average_rate'      => $this->average_rate,
            'currency'          => __('site.currency'),
            'reservation_price' => SiteSetting::where('key', 'reservation_price')->first()->value,
            'city'              => $this->city?->name,
            'city'              => [
                'id'   => $this->city_id,
                'name' => $this->city?->name,
            ],
            'category'          => [
                'id'   => $this->category_id,
                'name' => $this->category?->name,
            ],
            'image'             => $this->image,
        ];
    }
}
