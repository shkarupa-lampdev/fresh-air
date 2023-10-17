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
        Schema::create('data_eco_city_1755', function (Blueprint $table) {
            $table->id();
            $table->integer('place_id');
            $table->string('measurement_data');
            $table->string('option');
            $table->string('measurement_unit');
            $table->string('measurement_value');
            $table->dateTime('measurement_time');

            $table->timestamps();
        });

        Schema::create('data_eco_city_1753', function (Blueprint $table) {
            $table->id();
            $table->integer('place_id');
            $table->string('measurement_data');
            $table->string('option');
            $table->string('measurement_unit');
            $table->string('measurement_value');
            $table->dateTime('measurement_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_eco_city_1755');

        Schema::dropIfExists('data_eco_city_1753');
    }
};

