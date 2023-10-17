<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('split_measurement');


        /*
        |--------------------------------------------------------------------------
        | Ozone rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('temp_ozone')->after('Ozone');
        });

        DB::statement('UPDATE split_measurement_ua171 SET temp_ozone = Ozone');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('Ozone');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('ozone')->after('temp_ozone');
        });

        DB::statement('UPDATE split_measurement_ua171 SET ozone = temp_ozone');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('temp_ozone');
        });

        /*
        |--------------------------------------------------------------------------
        | dust_PM2,5 rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('dust_PM2_5')->after('dust_PM2,5');
        });

        DB::statement('UPDATE split_measurement_ua171 SET dust_PM2_5 = `dust_PM2,5`');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('dust_PM2,5');
        });

        /*
        |--------------------------------------------------------------------------
        | Ozone_ratio rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('temp_ozone_ratio')->after('Ozone_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET temp_ozone_ratio = Ozone_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('Ozone_ratio');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('ozone_ratio')->after('temp_ozone_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET ozone_ratio = temp_ozone_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('temp_ozone_ratio');
        });

        /*
        |--------------------------------------------------------------------------
        | dust_PM2,5_ratio rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('dust_PM2_5_ratio')->after('dust_PM2,5_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET dust_PM2_5_ratio = `dust_PM2,5_ratio`');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('dust_PM2,5_ratio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
         |--------------------------------------------------------------------------
         | Ozone rename
         |--------------------------------------------------------------------------
         */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('temp_ozone')->after('ozone');
        });

        DB::statement('UPDATE split_measurement_ua171 SET temp_ozone = ozone');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('ozone');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('Ozone')->after('temp_ozone');
        });

        DB::statement('UPDATE split_measurement_ua171 SET Ozone = temp_ozone');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('temp_ozone');
        });

        /*
        |--------------------------------------------------------------------------
        | dust_PM2,5 rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('dust_PM2,5')->after('dust_PM2_5');
        });

        DB::statement('UPDATE split_measurement_ua171 SET `dust_PM2,5` = dust_PM2_5');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('dust_PM2_5');
        });

        /*
        |--------------------------------------------------------------------------
        | Ozone_ratio rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('temp_ozone_ratio')->after('ozone_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET temp_ozone_ratio = ozone_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('ozone_ratio');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('Ozone_ratio')->after('temp_ozone_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET Ozone_ratio = temp_ozone_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('temp_ozone_ratio');
        });

        /*
        |--------------------------------------------------------------------------
        | dust_PM2,5_ratio rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('dust_PM2,5_ratio')->after('dust_PM2_5_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET `dust_PM2,5_ratio` = dust_PM2_5_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('dust_PM2_5_ratio');
        });

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
            $table->timestamps();
        });
    }
};
