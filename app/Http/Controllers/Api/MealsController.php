<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\meals;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\diabtes_record;




class MealsController extends Controller
{
    use ApiResponseTrait;

    public function generateWeeklyPlan()
    {
        $times = ['Breakfast', 'A.M.Snack', 'Lunch', 'P.M.Snack', 'Dinner'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $weeklyPlan = [];

        foreach ($days as $day) {
            $dayMeals = [];
            $totalCalories = 0;

            foreach ($times as $time) {
                // اختار وجبة عشوائية لكل وقت
                $meal = Meals::where('Time', $time)->inRandomOrder()->first();

                // لو في وجبة فعلاً
                if ($meal) {
                    $dayMeals[$time] = $meal;
                    $totalCalories += $meal->calories;
                }
            }

            $weeklyPlan[$day] = [
                'meals' => $dayMeals,
                'total_calories' => $totalCalories
            ];
        }

        return response()->json($weeklyPlan);
    }
}






