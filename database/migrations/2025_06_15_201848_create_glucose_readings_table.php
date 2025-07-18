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
    { Schema::create('CGMS', function (Blueprint $table) {
        $table->id();
        $table->float('current_glucose');
        $table->float('predicted_glucose');
        $table->string('trend');
        $table->text('suggested_action');
        $table->longText('plot_base64'); // stores the whole base64 string
        $table->timestamps();

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glucose_readings');
    }
};
