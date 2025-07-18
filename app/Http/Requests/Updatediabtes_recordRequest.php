<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Updatediabtes_recordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'User_id' => 'required|max:100',
            'hypertension'=> 'required|in:0,1',
            'heart_disease'=> 'required|in:0,1',
            'smoking_history'=> 'required|in:non-smoker,past_smoker,current',
            'bmi'=> 'required',
            'HbA1c_level'=> 'required',
            'blood_glucose_level'=> 'required|max:255',

        ];
    }
}
