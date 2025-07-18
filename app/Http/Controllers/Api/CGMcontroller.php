<?php

namespace App\Http\Controllers\Api;

use App\Models\CGM;
use App\Http\Resources\CGMR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class CGMcontroller extends Controller

    {
        use ApiResponseTrait;
    public function store(Request $request ){

        try {

            // Send POST request to FastAPI server
            $response = Http::get('http://127.0.0.1:8000/glucose_prediction/predict-from-simulation'
        );

            // Check if API request was successful
            if ($response->failed()) {
                return $this->apiResponse(null, 'Failed to get prediction from API', 500);
            }

            // Decode response
            $data = $response->json();

            // Ensure required keys exist
            if (!isset($data['current_glucose'])) {
                return $this->apiResponse(null, 'Invalid API response format', 500);
            }


            $post=CGM::create([
                'current_glucose' => $data['current_glucose'],
                'predicted_glucose' => $data['predicted_glucose'],
                'trend' => $data['trend'],
                'suggested_action' => $data['suggested_action'],
                'plot_base64' => $data['plot_base64'],
            ]);

                if($post){
                    return $this->apiResponse(new CGMR($post),message:'saved succesully',status:201);
                }
                else{
                    return $this->apiResponse(null,message:'the record not save',status:400);
                }


        } catch (\Exception $e) {
            // Handle unexpected errors
            return $this->apiResponse(null, 'An error occurred: ' . $e->getMessage(), 500);
        }

       }
    }

