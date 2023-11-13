<?php

namespace App\Http\Resources\Api\Doctor;

use App\Http\Resources\Api\Doctor\ClinicResource;
use App\Models\SiteSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorDetailsResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return
            [
            'id'                => $this->id,
            'currency'          => __('site.currency'),
            'name'              => $this->name,
            'qualifications'    => $this->qualifications,
            'average_rate'      => $this->average_rate,
            'reservation_price' => SiteSetting::where('key', 'reservation_price')->first()->value,
            'city'              => $this->city->name,
            'clinics'           => ClinicResource::collection($this->clinics),
            'city'              => [
                'id'   => $this->city_id,
                'name' => $this->city->name,
            ],
            'category'          => [
                'id'   => $this->category_id,
                'name' => $this->category->name,
            ],
            'image'             => $this->image,
        ];
    }
}
