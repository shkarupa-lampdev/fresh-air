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
            $table->double('pressure', 10, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | T3950716
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->double('pressure', 10, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | V0440346
        |--------------------------------------------------------------------------
        */
        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->double('pressure', 10, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | Split measurement ua171
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->double('pressure', 10, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Vaisala splits
        |--------------------------------------------------------------------------
        */
        Schema::table('vaisala_splits', function (Blueprint $table) {
            $table->double('pressure', 10, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | Station 1748
        |--------------------------------------------------------------------------
        */
        Schema::table('station1748', function (Blueprint $table) {
            $table->double('measurement_value', 10, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1753
        |--------------------------------------------------------------------------
        */
        Schema::table('station1753', function (Blueprint $table) {
            $table->double('measurement_value', 10, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1756
        |--------------------------------------------------------------------------
        */
        Schema::table('station1756', function (Blueprint $table) {
            $table->double('measurement_value', 10, 4)->nullable()->change();
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
            $table->double('pressure', 8, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | T3950716
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->double('pressure', 8, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | V0440346
        |--------------------------------------------------------------------------
        */
        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->double('pressure', 8, 4)->nullable()->change();

        });
        /*
        |--------------------------------------------------------------------------
        | Split measurement ua171
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->double('pressure', 8, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Vaisala splits
        |--------------------------------------------------------------------------
        */
        Schema::table('vaisala_splits', function (Blueprint $table) {
            $table->double('pressure', 8, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1748
        |--------------------------------------------------------------------------
        */
        Schema::table('station1748', function (Blueprint $table) {
            $table->double('measurement_value', 8, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1753
        |--------------------------------------------------------------------------
        */
        Schema::table('station1753', function (Blueprint $table) {
            $table->double('measurement_value', 8, 4)->nullable()->change();
        });
        /*
        |--------------------------------------------------------------------------
        | Station 1756
        |--------------------------------------------------------------------------
        */
        Schema::table('station1756', function (Blueprint $table) {
            $table->double('measurement_value', 8, 4)->nullable()->change();
        });
    }
};
