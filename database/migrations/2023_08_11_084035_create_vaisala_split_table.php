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
        Schema::create('vaisala_splits', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_id');
            $table->timestamp("timestamp_start")->nullable();
            $table->timestamp("timestamp_end")->nullable();

            $table->float("humidity")->nullable();
            $table->float("temperature")->nullable();
            $table->float("pressure")->nullable();
            $table->float("carbon_oxide")->nullable();
            $table->float("nitrogen_dioxide")->nullable();
            $table->float("dust_PM2_5")->nullable();
            $table->float("dust_PM10")->nullable();
            $table->float('dust_PM1')->nullable();
            $table->float('sulfur_dioxide')->nullable();
            $table->float('hydrogen_sulfide')->nullable();
            $table->float('max_wind_speed')->nullable();
            $table->float('rain_intensity')->nullable();
            $table->float('wind_direction')->nullable();
            $table->float('wind_speed')->nullable();
            $table->float('rain_accumulation')->nullable();

            $table->float("humidity_ratio")->nullable();
            $table->float("temperature_ratio")->nullable();
            $table->float("pressure_ratio")->nullable();
            $table->float("carbon_oxide_ratio")->nullable();
            $table->float("nitrogen_dioxide_ratio")->nullable();
            $table->float("dust_PM2_5_ratio")->nullable();
            $table->float("dust_PM10_ratio")->nullable();
            $table->float('dust_PM1_ratio')->nullable();
            $table->float('sulfur_dioxide_ratio')->nullable();
            $table->float('hydrogen_sulfide_ratio')->nullable();
            $table->float('max_wind_speed_ratio')->nullable();
            $table->float('rain_intensity_ratio')->nullable();
            $table->float('wind_direction_ratio')->nullable();
            $table->float('wind_speed_ratio')->nullable();
            $table->float('rain_accumulation_ratio')->nullable();


            $table->dateTime("interval_avg_time")->index();
            $table->tinyInteger("is_20m")->default(0);
            $table->tinyInteger("is_daily")->default(0);
            $table->tinyInteger("is_monthly")->default(0);
            $table->tinyInteger("is_yearly")->default(0);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaisala_splits');
    }
};
