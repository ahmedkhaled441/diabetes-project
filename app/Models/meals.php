<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class meals extends Model
{

    protected $fillable = [
        'ID',
        'Meal_name',
        'recipe',
        'Time',
        'calories',
    ];
}

