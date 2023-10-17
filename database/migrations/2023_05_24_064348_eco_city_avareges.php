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
        Schema::create('split_measurement', function (Blueprint $table) {
            $table->id();
            $table->timestamp("timestamp_start")->nullable();
            $table->timestamp("timestamp_end")->nullable();
            $table->string("sensor_id", 24);

            $table->float("AHTx0_temperature")->default(0);
            $table->float("AHTx0_humidity")->default(0);
            $table->float("BMP280_temperature")->default(0);
            $table->float("BMP280_pressure")->default(0);
            $table->float("MICS_6814_nh3")->default(0);
            $table->float("MICS_6814_co")->default(0);
            $table->float("MICS_6814_no2")->default(0);
            $table->float("RadKit_radiation")->default(0);
            $table->float("ZE03_NH3_nh3")->default(0);
            $table->float("ZE03_CL2_cl2")->default(0);
            $table->float("SDS011_pm25")->default(0);
            $table->float("SDS011_pm10")->default(0);

            $table->float("AHTx0_temperature_ratio")->default(0);
            $table->float("AHTx0_humidity_ratio")->default(0);
            $table->float("BMP280_temperature_ratio")->default(0);
            $table->float("BMP280_pressure_ratio")->default(0);
            $table->float("MICS_6814_nh3_ratio")->default(0);
            $table->float("MICS_6814_co_ratio")->default(0);
            $table->float("MICS_6814_no2_ratio")->default(0);
            $table->float("RadKit_radiation_ratio")->default(0);
            $table->float("ZE03_NH3_nh3_ratio")->default(0);
            $table->float("ZE03_CL2_cl2_ratio")->default(0);
            $table->float("SDS011_pm25_ratio")->default(0);
            $table->float("SDS011_pm10_ratio")->default(0);

            $table->dateTime("interval_avg_time")->index();
            $table->tinyInteger("is_20m")->default(0);
            $table->tinyInteger("is_daily")->default(0);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        }
);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split_measurement');
    }
};
