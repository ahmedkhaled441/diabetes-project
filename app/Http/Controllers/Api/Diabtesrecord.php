<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\diabtesrecords;
use App\Models\diabtes_record;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class Diabtesrecord extends Controller
{
    use ApiResponseTrait;
    public function index(){

        $posts = diabtesrecords::collection(diabtes_record::get());
        return $this->apiResponse($posts,message:'',status:200
    );
  }
  public function show($id){

    $post = diabtes_record::where('patient_id', $id)->first();

   if($post){
           return $this->apiResponse(new diabtesrecords($post),message:'ok',status:200);
            }
    else{
    return $this->apiResponse(null,message:'notfound',status:404);
        }
  }
public function showhistory($id){

    $post = diabtes_record::where('User_id', $id)->get();

   if($post->isNotEmpty()){
    return $this->apiResponse(diabtesrecords::collection($post), message: 'ok', status: 200);
   }
else{
    return $this->apiResponse(null,message:'notfound',status:404);
}

}
//done
public function store(Request $request ){

    try {
        $vr = User::findOrFail($request->User_id);
        if (!$vr->first_time_Record) {
            $vr->first_time_Record = 1;
            $vr->save();
        }

        $age = Carbon::parse($vr->birthday)->age;

        // Send POST request to FastAPI server
        $response = Http::post('http://127.0.0.1:8000/predict', [
            'age' => $age,
            'bmi' => $request->input('bmi'),
            'HbA1c_level' => $request->input('HbA1c_level'),
            'blood_glucose_level' => $request->input('blood_glucose_level'),
            'hypertension' => $request->input('hypertension'),
            'heart_disease' => $request->input('heart_disease'),
            'gender' => $vr->gender,
            'smoking_history' => $vr->smoking_history
        ]);

        // Check if API request was successful
        if ($response->failed()) {
            return $this->apiResponse(null, 'Failed to get prediction from API', 500);
        }

        // Decode response
        $data = $response->json();

        // Ensure required keys exist
        if (!isset($data['prediction'])) {
            return $this->apiResponse(null, 'Invalid API response format', 500);
        }

        // Return success response
       // return $this->apiResponse($data, 'Prediction retrieved successfully', 200);
        $validator=validator::make($request->all(),[
            'User_id' => 'required|max:100',
            'hypertension'=> 'required|in:0,1',
            'heart_disease'=> 'required|in:0,1',
            'bmi'=> 'required',
            'HbA1c_level'=> 'required',
            'blood_glucose_level'=> 'required|max:255',
           ]);
           if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);}

            $request['diabetes'] = $data['prediction'];
                 $vm=       $vr->update([
                'diabetes'=>$data['prediction'],
            ]);
            $post = diabtes_record::create([
            'User_id'=> $request->User_id,
            'hypertension'=> $request->hypertension,
            'heart_disease'=> $request->heart_disease,
            'bmi'=> $request->bmi,
            'HbA1c_level'=> $request->HbA1c_level,
            'blood_glucose_level'=> $request->blood_glucose_level,
            // 'diabetes'=>$data['prediction'],
        ]);
        $post['diabetes'] = $data['prediction'];


            if($post && $vm){
                return $this->apiResponse(new diabtesrecords($post),message:'saved succesully',status:201);
            }
            else{
                return $this->apiResponse(null,message:'the record not save',status:400);
            }


    } catch (\Exception $e) {
        // Handle unexpected errors
        return $this->apiResponse(null, 'An error occurred: ' . $e->getMessage(), 500);
    }

   }

public function destroy($id){

    $post=diabtes_record::find($id);

    if(!$post){
        return $this->apiResponse(null,'The post Not Found',404);
    }

    $post->delete();

    if($post){
        return $this->apiResponse(null,'The post deleted',200);
    }
}


    public function getPrediction(Request $request)
    {

        try {
            // Send POST request to FastAPI server
            $response = Http::post('http://127.0.0.1:8000/predict', [
                'age' => $request->input('age'),
                'bmi' => $request->input('bmi'),
                'HbA1c_level' => $request->input('HbA1c_level'),
                'blood_glucose_level' => $request->input('blood_glucose_level'),
                'hypertension' => $request->input(key: 'hypertension'),
                'heart_disease' => $request->input('heart_disease'),
                'gender' => $request->input('gender'),
                'smoking_history' => $request->input('smoking_history')
            ]);

            // Check if API request was successful
            if ($response->failed()) {
                return $this->apiResponse(null, 'Failed to get prediction from API', 500);
            }

            // Decode response
            $data = $response->json();

            // Ensure required keys exist
            if (!isset($data['prediction'])) {
                return $this->apiResponse(null, 'Invalid API response format', 500);
            }

            // Return success response
            return $this->apiResponse($data, 'Prediction retrieved successfully', 200);

        } catch (\Exception $e) {
            // Handle unexpected errors
            return $this->apiResponse(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }
    public function DiabetesType(Request $request)
    {
try {
    // Find the user by ID
    $user = User::findOrFail($request->User_id);
    $age = Carbon::parse($user->birthday)->age;

    // Prepare the payload for the FastAPI request
    $payload = [
        "age" => $age,
        "gender" => $user->gender,
        "insulin" => $request->input('insulin'),
        "glucose" => $request->input('glucose'),
        "hba1c" => $request->input('hba1c'),
        "bmi" => $request->input('bmi'),
        "homa_ir" => $request->input('homa_ir'),
        "family_history" => $request->input('family_history'),
        "pregnant" => $request->input('pregnant'),
        "c_peptide" => $request->input('c_peptide'),
        "gad_antibodies" => $request->input('gad_antibodies')
    ];

    // Send POST request to FastAPI server
    $response = Http::post('http://127.0.0.1:8000/diabetes_type/predict_diabetes_type', $payload);

    // Check if API request was successful
    if ($response->failed()) {
        Log::error("API request failed", [
            'user_id' => $user->id,
            'payload' => $payload,
            'response' => $response->body()
        ]);

        return $this->apiResponse(null, 'Failed to get prediction from API', 500);
    }

    // Decode response
    $data = $response->json();

    // Check for required response keys
    if (!isset($data['diabetes_type'])) {
        Log::error("Invalid API response format", [
            'user_id' => $user->id,
            'response' => $data
        ]);

        return $this->apiResponse(null, 'Invalid API response format', 500);
    }

    // Update the user record with the predicted diabetes type
    $updated = $user->update([
        'DiabetesType' => $data['diabetes_type'],
    ]);

    // Check if the update was successful
    if ($updated) {
        return $this->apiResponse($data['diabetes_type'], 'Prediction saved successfully', 201);
    } else {
        return $this->apiResponse(null, 'Failed to save prediction', 400);
    }

} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    // Handle user not found
    return $this->apiResponse(null, 'User not found', 404);
} catch (\Exception $e) {
    // Handle other unexpected errors
    Log::error("Unexpected error", ['exception' => $e]);
    return $this->apiResponse(null, 'An error occurred: ' . $e->getMessage(), 500);
}
    }
}
