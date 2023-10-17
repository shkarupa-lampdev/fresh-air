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

        Schema::create('station_T3950713', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->dateTime('measurement_time');
            $table->string("option");
            $table->float("measurement_value")->default(0);
            $table->string('unique_hash')->unique()->index();
            $table->timestamps();
        });
        Schema::create('station_T3950716', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->dateTime('measurement_time');
            $table->string("option");
            $table->float("measurement_value")->default(0);
            $table->string('unique_hash')->unique()->index();
            $table->timestamps();
        });
        Schema::create('station_V0440346', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->dateTime('measurement_time');
            $table->string("option");
            $table->float("measurement_value")->default(0);
            $table->string('unique_hash')->unique()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_T3950713');
        Schema::dropIfExists('station_T3950716');
        Schema::dropIfExists('station_V0440346');
    }
};
