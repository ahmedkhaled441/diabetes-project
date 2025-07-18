<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlucosePrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'User_id',
        'pre_glucose',
        'carbs_grams',
        'insulin_units',
        'activity_minutes_prev_hour',
        'sleep_hours_prev_night',
        'predicted_glucose',
        'risk_class'
    ];
}
