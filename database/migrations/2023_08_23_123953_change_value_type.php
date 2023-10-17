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
        | Split measurement ua171
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
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
            $table->dropColumn("ozone");
            $table->dropColumn("radiation");
            $table->dropColumn("chlorine");
            $table->dropColumn("ammonia");
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->double('humidity', 8, 4)->nullable()->after('timestamp_end');
            $table->double('temperature', 8, 4)->nullable()->after('humidity');
            $table->double('pressure', 8, 4)->nullable()->after('temperature');
            $table->double('carbon_oxide', 8, 4)->nullable()->after('pressure');
            $table->double('ozone', 8, 4)->nullable()->after('carbon_oxide');
            $table->double('radiation', 8, 4)->nullable()->after('ozone');
            $table->double('chlorine', 8, 4)->nullable()->after('radiation');
            $table->double('ammonia', 8, 4)->nullable()->after('chlorine');
            $table->double('nitrogen_dioxide', 8, 4)->nullable()->after('ammonia');
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

        /*
        |--------------------------------------------------------------------------
        | Vaisala splits
        |--------------------------------------------------------------------------
        */
        Schema::table('vaisala_splits', function (Blueprint $table) {
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

        Schema::table('vaisala_splits', function (Blueprint $table) {
            $table->double('humidity', 8, 4)->nullable()->after('timestamp_end');
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
        /*
        |--------------------------------------------------------------------------
        | Station 1748
        |--------------------------------------------------------------------------
        */

        Schema::table('station1748', function (Blueprint $table) {
            $table->dropColumn("measurement_value");
        });

        Schema::table('station1748', function (Blueprint $table) {
            $table->double('measurement_value', 8, 4)->nullable()->after('measurement_unit');
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1753
        |--------------------------------------------------------------------------
        */

        Schema::table('station1753', function (Blueprint $table) {
            $table->dropColumn("measurement_value");
        });

        Schema::table('station1753', function (Blueprint $table) {
            $table->double('measurement_value', 8, 4)->nullable()->after('measurement_unit');
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1756
        |--------------------------------------------------------------------------
        */

        Schema::table('station1756', function (Blueprint $table) {
            $table->dropColumn("measurement_value");
        });

        Schema::table('station1756', function (Blueprint $table) {
            $table->double('measurement_value', 8, 4)->nullable()->after('measurement_unit');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Split measurement ua171
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
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
            $table->dropColumn("ozone");
            $table->dropColumn("radiation");
            $table->dropColumn("chlorine");
            $table->dropColumn("ammonia");
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float("humidity")->nullable();
            $table->float("temperature")->nullable();
            $table->float("pressure")->nullable();
            $table->float("ammonia")->nullable();
            $table->float("carbon_oxide")->nullable();
            $table->float("nitrogen_dioxide")->nullable();
            $table->float("radiation")->nullable();
            $table->float("chlorine")->nullable();
            $table->float("dust_PM2_5")->nullable();
            $table->float("dust_PM10")->nullable();
            $table->float("ozone")->nullable();
            $table->float('sulfur_dioxide')->nullable();
            $table->float('hydrogen_sulfide')->nullable();
            $table->float('dust_PM1')->nullable();
            $table->float('max_wind_speed')->nullable();
            $table->float('rain_intensity')->nullable();
            $table->float('wind_direction')->nullable();
            $table->float('wind_speed')->nullable();
            $table->float('rain_accumulation')->nullable();
        });

        /*
        |--------------------------------------------------------------------------
        | Vaisala splits
        |--------------------------------------------------------------------------
        */
        Schema::table('vaisala_splits', function (Blueprint $table) {
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

        Schema::table('vaisala_splits', function (Blueprint $table) {
            $table->float("humidity")->nullable();
            $table->float("temperature")->nullable();
            $table->float("pressure")->nullable();
            $table->float("carbon_oxide")->nullable();
            $table->float("nitrogen_dioxide")->nullable();
            $table->float("dust_PM2_5")->nullable();
            $table->float("dust_PM10")->nullable();
            $table->float('sulfur_dioxide')->nullable();
            $table->float('hydrogen_sulfide')->nullable();
            $table->float('dust_PM1')->nullable();
            $table->float('max_wind_speed')->nullable();
            $table->float('rain_intensity')->nullable();
            $table->float('wind_direction')->nullable();
            $table->float('wind_speed')->nullable();
            $table->float('rain_accumulation')->nullable();
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1748
        |--------------------------------------------------------------------------
        */

        Schema::table('station1748', function (Blueprint $table) {
            $table->dropColumn("measurement_value");
        });

        Schema::table('station1748', function (Blueprint $table) {
            $table->float('measurement_value')->nullable()->after('measurement_unit');
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1753
        |--------------------------------------------------------------------------
        */

        Schema::table('station1753', function (Blueprint $table) {
            $table->dropColumn("measurement_value");
        });

        Schema::table('station1753', function (Blueprint $table) {
            $table->float('measurement_value')->nullable()->after('measurement_unit');
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1756
        |--------------------------------------------------------------------------
        */

        Schema::table('station1756', function (Blueprint $table) {
            $table->dropColumn("measurement_value");
        });

        Schema::table('station1756', function (Blueprint $table) {
            $table->float('measurement_value')->nullable()->after('measurement_unit');
        });
    }
};
