<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class diabtes_record extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'User_id',
        'hypertension',
        'heart_disease',
        'bmi',
        'HbA1c_level',
        'blood_glucose_level',
        ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
