<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class excercises extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'activty_level'=>$this-> activty_level,
            'excercise_ID'=>$this-> excercise_ID,
            'Name'=>$this-> Name,
            'Type'=>$this-> Type,
            'Time'=>$this-> Time,
            'Sets'=>$this-> Sets,
        ];
    }
}
