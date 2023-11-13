<?php

namespace App\Http\Resources\Api\Lab;

use Illuminate\Http\Resources\Json\JsonResource;

class LabDetailsResource extends JsonResource {
    public function toArray($request) {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'address'    => $this->address,
            'image'      => $this->image,
            'rate_avg'   => $this->rate_avg,
            'branches'   => LabBranchResource::collection($this->branches),
            'city'       => [
                'id'   => $this->city_id,
                'name' => $this->city?->name,
            ],
            'categories' => $this->labCategories->unique()->map(function ($category) {
                return [
                    // 'category_id'        => $category->id,
                    'lab_category_id' => $category->id,
                    'name'            => $category->name,
                    'image'           => $category->image,
                ];
            }),
            'comments'   => $this->reservations()->where('comment', '!=', null)->get()->map(function ($reservation) {
                return [
                    'id'      => $reservation->id,
                    'comment' => $reservation->comment,
                    'rate'    => $reservation->rate,
                    'date'    => $reservation->created_at->diffForHumans(),
                    'user'    => [
                        'id'    => $reservation->user_id,
                        'name'  => $reservation->user->name,
                        'image' => $reservation->user->image,
                    ],
                ];
            }),
        ];
    }
}
