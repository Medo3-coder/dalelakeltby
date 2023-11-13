<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        
        if ($this->childes()->count() > 0 ) {
            $nextStep = url('/api/categories/' . $this->id) ;
            $nextStepMethod = 'GET' ;
        }else{
            $nextStep = url('/api/filter-doctors') ;
            if ($this->type == 'lab') {
                $nextStep = url('/api/filter-labs');
            }
            $nextStepMethod = 'POST' ;

        }

        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'image'              => $this->image,
            'next_step'          => $nextStep,
            'next_step_method'   => $nextStepMethod ,
            'type'               => $this->type,
            'has_childes'        => $this->childes()->count() > 0 ? true : false ,  
        ];
    }
}