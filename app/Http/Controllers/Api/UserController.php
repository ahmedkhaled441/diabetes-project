<?php

namespace App\Http\Controllers\Api;



use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function show($id)
    {
        try {
            $user = user::findOrFail($id);

            return response()->json([
                'message' => 'User found successfully!',
                'user' => $user
            ], Response::HTTP_OK);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User Not Found',
                'message' => "No user found with ID: $id"
            ], Response::HTTP_NOT_FOUND);

        }
    }

    // 📌 Update a user
    public function update(Request $request)
    {

            // Find the user
            $user = User::findOrFail($request->id);


            // Validate the incoming request
            $validated = $request->validate([
                'activity_level'=>'in:1,2,3,4',
                'CGM_or_manual'=>'in:0,1',
                'smoking_history' => 'in:non-smoker,past_smoker,current'
            ]);

            // Update the user with the validated data
            $user->update([
                "activity_level" => $request->activity_level,
                "smoking_history" => $request->smoking_history,
                "CGM_or_manual" => $request->CGM_or_manual,
            ]);


            return response()->json([
                'message' => 'User updated successfully!',
                'user' => $user
            ], Response::HTTP_OK);


    }
}



