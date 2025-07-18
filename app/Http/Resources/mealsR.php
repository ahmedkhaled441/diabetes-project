<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class mealsR extends JsonResource
{
    public function toArray(Request $request): array
    {
        return[
            'ID'=>$this-> ID,
            'Meal_name'=>$this-> Meal_name,
            'recipe'=>$this-> recipe,
            'Type'=>$this-> Type,
            'Time'=>$this-> Time,
            'calories'=>$this-> calories,
        ];
    }
}
