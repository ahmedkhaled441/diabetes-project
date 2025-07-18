<?php

use App\Http\Controllers\Api\MealsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExcercisesController;
use app\http\Controllers\Api\DiabetesType;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DiabtesRecord;
use App\Http\Controllers\Api\CGMcontroller;
use App\Http\Controllers\Api\GlucosePredictionController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware(['auth:api'])->group(function () {
Route::get('/Excercises/{id}', [ExcercisesController::class, 'show']);

Route::controller(DiabtesRecord::class)->group(function ()   {
Route::get('/records/{id}','showhistory');
Route::get('/records','index');
Route::get('/record/{id}','show');
Route::post('/records','store');
Route::post('/records/{id}','update');
Route::delete('/records/{id}','destroy');
Route::post('/predictions', 'getPrediction');
Route::post('/DiabetesType','DiabetesType');
});
Route::controller(UserController::class)->group(function ()   {
Route::get('/User/{id}','show');
Route::put('/User','update');

});
Route::controller(CGMcontroller::class)->group(function ()   {
    Route::get('/CGM','store');
});
Route::controller(MealsController::class)->group(function ()   {
    Route::get('/meals','generateWeeklyPlan');
});
Route::controller(GlucosePredictionController::class)->group(function ()   {
    Route::post('/GlucosePredictionmanual',action: 'predict');
});
});


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

