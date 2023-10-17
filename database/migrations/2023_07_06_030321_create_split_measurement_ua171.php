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
        Schema::create('split_measurement_ua171', function (Blueprint $table) {
            $table->id();
            $table->timestamp("timestamp_start")->nullable();
            $table->timestamp("timestamp_end")->nullable();

            $table->float("humidity")->default(0);
            $table->float("temperature")->default(0);
            $table->float("pressure")->default(0);
            $table->float("ammonia")->default(0);
            $table->float("carbon_oxide")->default(0);
            $table->float("nitrogen_dioxide")->default(0);
            $table->float("radiation")->default(0);
            $table->float("сhlorine")->default(0);
            $table->float("dust_PM2,5")->default(0);
            $table->float("dust_PM10")->default(0);
            $table->float("Ozone")->default(0);

            $table->float("humidity_ratio")->default(0);
            $table->float("temperature_ratio")->default(0);
            $table->float("pressure_ratio")->default(0);
            $table->float("ammonia_ratio")->default(0);
            $table->float("carbon_oxide_ratio")->default(0);
            $table->float("nitrogen_dioxide_ratio")->default(0);
            $table->float("radiation_ratio")->default(0);
            $table->float("сhlorine_ratio")->default(0);
            $table->float("dust_PM2,5_ratio")->default(0);
            $table->float("dust_PM10_ratio")->default(0);
            $table->float("Ozone_ratio")->default(0);

            $table->dateTime("interval_avg_time")->index();
            $table->tinyInteger("is_20m")->default(0);
            $table->tinyInteger("is_daily")->default(0);
            $table->tinyInteger("is_monthly")->default(0);
            $table->tinyInteger("is_yearly")->default(0);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split_measurement_ua171');
    }
};
