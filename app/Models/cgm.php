<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cgm extends Model
{
    protected $fillable = [
        'current_glucose',
        'predicted_glucose',
        'trend',
        'suggested_action',
        'plot_base64',
    ];
}
