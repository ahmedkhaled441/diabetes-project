<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreexcercisesRequest;
use App\Models\diabtes_record;
use App\Models\excercises;
use App\Models\User;
use Illuminate\Http\Request;


class ExcercisesController extends Controller
{
    use ApiResponseTrait;
    public function index(){

        $posts = excercises::collection(excercises::get());
        return $this->apiResponse($posts,message:'',status:200
    );
  }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('entrytest');
    }


    public function show( $id)
    {

        $activite = User::where('id', $id)->value('activity_level');

    if (!$activite) {
        return $this->apiResponse(null, 'Activity level not found', 404);
    }

    $exerciseRanges = [
        1 => [1, 2],
        2 => [3, 5],
        3 => [6, 10],
        4 => [1, 7]
    ];

    if (!isset($exerciseRanges[$activite])) {
        return $this->apiResponse(null, 'Invalid activity level', 400);
    }

    $view = excercises::whereBetween('excercise_ID', $exerciseRanges[$activite])->get();

    if ($view->isEmpty()) {
        return $this->apiResponse(null, 'No exercises found', 404);
    }

    return $this->apiResponse([
        'activity_level' => $activite,
        'exercises' => $view // Return all records as an array
    ], 'ok', 200);
}
}
