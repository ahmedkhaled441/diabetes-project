<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GlucosePrediction;

class GlucosePredictionController extends Controller
{
    public function predict(Request $request)
    {
        $validated = $request->validate([
            'User_id' => 'required|max:100',
            'pre_glucose' => 'required|numeric|min:40|max:400',
            'carbs_grams' => 'required|numeric|min:0|max:250',
            'insulin_units' => 'required|numeric|min:0|max:30',
            'activity_minutes_prev_hour' => 'required|integer|min:0|max:180',
            'sleep_hours_prev_night' => 'required|numeric|min:3|max:10',
        ]);

        // Send request to FastAPI
        $response = Http::post('http://127.0.0.1:8000/glucose_prediction_manual/predictmanual', $validated);

        if ($response->failed()) {
            return response()->json(['error' => 'Prediction failed'], 500);
        }

        $result = $response->json();

        // Save to database
        GlucosePrediction::create(array_merge($validated, [
            'predicted_glucose' => $result['predicted_glucose'],
            'risk_class' => $result['risk_class']
        ]));

        return response()->json($result);
    }
}
