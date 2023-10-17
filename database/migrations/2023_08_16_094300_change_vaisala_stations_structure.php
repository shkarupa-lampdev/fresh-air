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
        /*
        |--------------------------------------------------------------------------
        | T3950713
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->dropColumn('sensor_id');
            $table->dropColumn('option');
            $table->dropColumn('measurement_value');
            $table->dropColumn('unique_hash');

            $table->dropColumn('measurement_time');

            $table->double('humidity', 8, 4)->nullable()->after('measurement_time');
            $table->double('temperature', 8, 4)->nullable()->after('humidity');
            $table->double('pressure', 8, 4)->nullable()->after('temperature');
            $table->double('carbon_oxide', 8, 4)->nullable()->after('pressure');
            $table->double('nitrogen_dioxide', 8, 4)->nullable()->after('carbon_oxide');
            $table->double('dust_PM2_5', 8, 4)->nullable()->after('nitrogen_dioxide');
            $table->double('dust_PM10', 8, 4)->nullable()->after('dust_PM2_5');
            $table->double('dust_PM1', 8, 4)->nullable()->after('dust_PM10');
            $table->double('sulfur_dioxide', 8, 4)->nullable()->after('dust_PM1');
            $table->double('hydrogen_sulfide', 8, 4)->nullable()->after('sulfur_dioxide');
            $table->double('max_wind_speed', 8, 4)->nullable()->after('hydrogen_sulfide');
            $table->double('rain_intensity', 8, 4)->nullable()->after('max_wind_speed');
            $table->double('wind_direction', 8, 4)->nullable()->after('rain_intensity');
            $table->double('wind_speed', 8, 4)->nullable()->after('wind_direction');
            $table->double('rain_accumulation', 8, 4)->nullable()->after('wind_speed');
        });


        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->dateTime("measurement_time")->unique();
        });
        /*
        |--------------------------------------------------------------------------
        | T3950716
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->dropColumn('sensor_id');
            $table->dropColumn('option');
            $table->dropColumn('measurement_value');
            $table->dropColumn('unique_hash');

            $table->dropColumn('measurement_time');

            $table->double('humidity', 8, 4)->nullable()->after('measurement_time');
            $table->double('temperature', 8, 4)->nullable()->after('humidity');
            $table->double('pressure', 8, 4)->nullable()->after('temperature');
            $table->double('carbon_oxide', 8, 4)->nullable()->after('pressure');
            $table->double('nitrogen_dioxide', 8, 4)->nullable()->after('carbon_oxide');
            $table->double('dust_PM2_5', 8, 4)->nullable()->after('nitrogen_dioxide');
            $table->double('dust_PM10', 8, 4)->nullable()->after('dust_PM2_5');
            $table->double('dust_PM1', 8, 4)->nullable()->after('dust_PM10');
            $table->double('sulfur_dioxide', 8, 4)->nullable()->after('dust_PM1');
            $table->double('hydrogen_sulfide', 8, 4)->nullable()->after('sulfur_dioxide');
            $table->double('max_wind_speed', 8, 4)->nullable()->after('hydrogen_sulfide');
            $table->double('rain_intensity', 8, 4)->nullable()->after('max_wind_speed');
            $table->double('wind_direction', 8, 4)->nullable()->after('rain_intensity');
            $table->double('wind_speed', 8, 4)->nullable()->after('wind_direction');
            $table->double('rain_accumulation', 8, 4)->nullable()->after('wind_speed');
        });

        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->dateTime("measurement_time")->unique();
        });
        /*
        |--------------------------------------------------------------------------
        | V0440346
        |--------------------------------------------------------------------------
        */
        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->dropColumn('sensor_id');
            $table->dropColumn('option');
            $table->dropColumn('measurement_value');
            $table->dropColumn('unique_hash');

            $table->dropColumn('measurement_time');

            $table->double('humidity', 8, 4)->nullable()->after('measurement_time');
            $table->double('temperature', 8, 4)->nullable()->after('humidity');
            $table->double('pressure', 8, 4)->nullable()->after('temperature');
            $table->double('carbon_oxide', 8, 4)->nullable()->after('pressure');
            $table->double('nitrogen_dioxide', 8, 4)->nullable()->after('carbon_oxide');
            $table->double('dust_PM2_5', 8, 4)->nullable()->after('nitrogen_dioxide');
            $table->double('dust_PM10', 8, 4)->nullable()->after('dust_PM2_5');
            $table->double('dust_PM1', 8, 4)->nullable()->after('dust_PM10');
            $table->double('sulfur_dioxide', 8, 4)->nullable()->after('dust_PM1');
            $table->double('hydrogen_sulfide', 8, 4)->nullable()->after('sulfur_dioxide');
            $table->double('max_wind_speed', 8, 4)->nullable()->after('hydrogen_sulfide');
            $table->double('rain_intensity', 8, 4)->nullable()->after('max_wind_speed');
            $table->double('wind_direction', 8, 4)->nullable()->after('rain_intensity');
            $table->double('wind_speed', 8, 4)->nullable()->after('wind_direction');
            $table->double('rain_accumulation', 8, 4)->nullable()->after('wind_speed');
        });

        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->dateTime("measurement_time")->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | T3950713
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->string('sensor_id')->nullable()->after('id');
            $table->string('option')->nullable()->after('measurement_time');
            $table->float('measurement_value')->default(0)->after('option');
            $table->string('unique_hash')->unique()->index();

            $table->dropColumn('measurement_time');

            $table->dropColumn("humidity");
            $table->dropColumn("temperature");
            $table->dropColumn("pressure");
            $table->dropColumn("carbon_oxide");
            $table->dropColumn("nitrogen_dioxide");
            $table->dropColumn("dust_PM2_5");
            $table->dropColumn("dust_PM10");
            $table->dropColumn('dust_PM1');
            $table->dropColumn('sulfur_dioxide');
            $table->dropColumn('hydrogen_sulfide');
            $table->dropColumn('max_wind_speed');
            $table->dropColumn('rain_intensity');
            $table->dropColumn('wind_direction');
            $table->dropColumn('wind_speed');
            $table->dropColumn('rain_accumulation');
        });

        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->dateTime("measurement_time");
        });
        /*
        |--------------------------------------------------------------------------
        | T3950716
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->string('sensor_id')->nullable()->after('id');
            $table->string('option')->nullable()->after('measurement_time');
            $table->float('measurement_value')->default(0)->after('option');
            $table->string('unique_hash')->unique()->index();

            $table->dropColumn('measurement_time');

            $table->dropColumn("humidity");
            $table->dropColumn("temperature");
            $table->dropColumn("pressure");
            $table->dropColumn("carbon_oxide");
            $table->dropColumn("nitrogen_dioxide");
            $table->dropColumn("dust_PM2_5");
            $table->dropColumn("dust_PM10");
            $table->dropColumn('dust_PM1');
            $table->dropColumn('sulfur_dioxide');
            $table->dropColumn('hydrogen_sulfide');
            $table->dropColumn('max_wind_speed');
            $table->dropColumn('rain_intensity');
            $table->dropColumn('wind_direction');
            $table->dropColumn('wind_speed');
            $table->dropColumn('rain_accumulation');
        });

        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->dateTime("measurement_time");
        });
        /*
        |--------------------------------------------------------------------------
        | V0440346
        |--------------------------------------------------------------------------
        */
        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->string('sensor_id')->nullable()->after('id');
            $table->string('option')->nullable()->after('measurement_time');
            $table->float('measurement_value')->default(0)->after('option');
            $table->string('unique_hash')->unique()->index();

            $table->dropColumn('measurement_time');

            $table->dropColumn("humidity");
            $table->dropColumn("temperature");
            $table->dropColumn("pressure");
            $table->dropColumn("carbon_oxide");
            $table->dropColumn("nitrogen_dioxide");
            $table->dropColumn("dust_PM2_5");
            $table->dropColumn("dust_PM10");
            $table->dropColumn('dust_PM1');
            $table->dropColumn('sulfur_dioxide');
            $table->dropColumn('hydrogen_sulfide');
            $table->dropColumn('max_wind_speed');
            $table->dropColumn('rain_intensity');
            $table->dropColumn('wind_direction');
            $table->dropColumn('wind_speed');
            $table->dropColumn('rain_accumulation');
        });

        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->dateTime("measurement_time");
        });
    }
};
