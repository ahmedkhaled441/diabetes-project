<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[

        "id"=>$this-> id,
        "name"=>$this-> name,
        "lastname"=>$this-> lastname,
        "email"=>$this-> email,
        "phone"=>$this-> phone,
        "first_time_Record"=>$this-> first_time_Record,
        "gender"=>$this-> gender,
        "activity_level"=>$this->activity_level,
        "diabetes"=>$this-> diabetes,
        "smoking_history"=>$this-> smoking_history,
        ];
    }
}
