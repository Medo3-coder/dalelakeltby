<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    private $token = '';

    public function setToken($value) {
        $this->token = $value;
        return $this;
    }

    public function toArray($request) {

        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'country_code'     => $this->country_code,
            'phone'            => $this->phone,
            'full_phone'       => $this->full_phone,
            'weight'           => $this->weight ? number_format($this->weight) : '',
            'age'              => $this->age ? $this->age : '',
            'height'           => $this->height ? number_format($this->height) : '',
            'image'            => $this->image ?? '',
            'gender'           => $this->gender ?? '',
            'chranic_diseases' => ChranicDiseasesResource::collection($this->diseases),
            'blood_type'       => $this->bloodType->name,
            'blood_type_id'    => $this->blood_type_id,
            'lang'             => $this->lang,
            'is_notify'        => $this->is_notify,
            'token'            => $this->token,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
            'map_desc'         => $this->map_desc,
        ];
    }
}
