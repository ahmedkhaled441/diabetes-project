<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreexcercisesRequest extends FormRequest
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
            'excercise_ID' => 'required|max:100',
            'Name' => 'required',
            'Type' => 'required|max:255',
            'Time'=> 'required|max:100',
            'Sets'=> 'required|max:100',
            'activity_level'=>'required|in:1,2,3,4'
        ];
    }
}
