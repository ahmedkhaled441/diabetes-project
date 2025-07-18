<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class diabtesrecords extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
     'id'=>$this-> id,
     'User_id'=>$this-> User_id,
     'hypertension'=>$this-> hypertension,
     'heart_disease'=>$this-> heart_disease,
     'bmi'=>$this-> bmi,
     'HbA1c_level'=>$this-> HbA1c_level,
     'blood_glucose_level'=>$this-> blood_glucose_level,
     "diabetes"=>$this-> diabetes,
        ];
    }
}
