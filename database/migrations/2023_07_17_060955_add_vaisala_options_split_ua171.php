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
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float("humidity")->nullable()->change();
            $table->float("temperature")->nullable()->change();
            $table->float("pressure")->nullable()->change();
            $table->float("ammonia")->nullable()->change();
            $table->float("carbon_oxide")->nullable()->change();
            $table->float("nitrogen_dioxide")->nullable()->change();
            $table->float("radiation")->nullable()->change();
            $table->float("сhlorine")->nullable()->change();
            $table->float("dust_PM2_5")->nullable()->change();
            $table->float("dust_PM10")->nullable()->change();
            $table->float("ozone")->nullable()->change();
            $table->float('sulfur_dioxide')->nullable();
            $table->float('hydrogen_sulfide')->nullable();
            $table->float('dust_PM1')->nullable();
            $table->float('max_wind_speed')->nullable();
            $table->float('rain_intensity')->nullable();
            $table->float('wind_direction')->nullable();
            $table->float('wind_speed')->nullable();
            $table->float('rain_accumulation')->nullable();


            $table->float("humidity_ratio")->nullable()->change();
            $table->float("temperature_ratio")->nullable()->change();
            $table->float("pressure_ratio")->nullable()->change();
            $table->float("ammonia_ratio")->nullable()->change();
            $table->float("carbon_oxide_ratio")->nullable()->change();
            $table->float("nitrogen_dioxide_ratio")->nullable()->change();
            $table->float("radiation_ratio")->nullable()->change();
            $table->float("сhlorine_ratio")->nullable()->change();
            $table->float("dust_PM2_5_ratio")->nullable()->change();
            $table->float("dust_PM10_ratio")->nullable()->change();
            $table->float("ozone_ratio")->nullable()->change();
            $table->float('sulfur_dioxide_ratio')->nullable();
            $table->float('hydrogen_sulfide_ratio')->nullable();
            $table->float('dust_PM1_ratio')->nullable();
            $table->float('max_wind_speed_ratio')->nullable();
            $table->float('rain_intensity_ratio')->nullable();
            $table->float('wind_direction_ratio')->nullable();
            $table->float('wind_speed_ratio')->nullable();
            $table->float('rain_accumulation_ratio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('split_measurement_ua171', function (Blueprint $table) {

            $table->float("humidity")->default(0)->change();
            $table->float("temperature")->default(0)->change();
            $table->float("pressure")->default(0)->change();
            $table->float("ammonia")->default(0)->change();
            $table->float("carbon_oxide")->default(0)->change();
            $table->float("nitrogen_dioxide")->default(0)->change();
            $table->float("radiation")->default(0)->change();
            $table->float("сhlorine")->default(0)->change();
            $table->float("dust_PM2_5")->default(0)->change();
            $table->float("dust_PM10")->default(0)->change();
            $table->float("ozone")->default(0)->change();
            $table->dropColumn('sulfur_dioxide');
            $table->dropColumn('hydrogen_sulfide');
            $table->dropColumn('dust_PM1');
            $table->dropColumn('max_wind_speed');
            $table->dropColumn('rain_intensity');
            $table->dropColumn('wind_direction');
            $table->dropColumn('wind_speed');
            $table->dropColumn('rain_accumulation');

            $table->float("humidity_ratio")->default(0)->change();
            $table->float("temperature_ratio")->default(0)->change();
            $table->float("pressure_ratio")->default(0)->change();
            $table->float("ammonia_ratio")->default(0)->change();
            $table->float("carbon_oxide_ratio")->default(0)->change();
            $table->float("nitrogen_dioxide_ratio")->default(0)->change();
            $table->float("radiation_ratio")->default(0)->change();
            $table->float("сhlorine_ratio")->default(0)->change();
            $table->float("dust_PM2_5_ratio")->default(0)->change();
            $table->float("dust_PM10_ratio")->default(0)->change();
            $table->float("ozone_ratio")->default(0)->change();
            $table->dropColumn('sulfur_dioxide_ratio');
            $table->dropColumn('hydrogen_sulfide_ratio');
            $table->dropColumn('dust_PM1_ratio');
            $table->dropColumn('max_wind_speed_ratio');
            $table->dropColumn('rain_intensity_ratio');
            $table->dropColumn('wind_direction_ratio');
            $table->dropColumn('wind_speed_ratio');
            $table->dropColumn('rain_accumulation_ratio');
        });
    }
};
