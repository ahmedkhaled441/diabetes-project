<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('glucose_predictions', function (Blueprint $table) {
            $table->id();
            $table->float('pre_glucose');
            $table->float('carbs_grams');
            $table->float('insulin_units');
            $table->integer('activity_minutes_prev_hour');
            $table->float('sleep_hours_prev_night');
            $table->float('predicted_glucose');
            $table->string('risk_class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glucose_predictions');
    }
};
