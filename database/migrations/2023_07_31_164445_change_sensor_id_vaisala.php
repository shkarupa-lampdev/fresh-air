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
            $table->string('sensor_id')->nullable()->after('place_id');
        });

        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->dropColumn('place_id');
        });

        /*
        |--------------------------------------------------------------------------
        | T3950716
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->string('sensor_id')->nullable()->after('place_id');
        });

        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->dropColumn('place_id');
        });

        /*
        |--------------------------------------------------------------------------
        | V0440346
        |--------------------------------------------------------------------------
        */
        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->string('sensor_id')->nullable()->after('place_id');
        });

        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->dropColumn('place_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | T3950716
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->string('place_id')->nullable()->after('sensor_id');
        });

        Schema::table('station_T3950716', function (Blueprint $table) {
            $table->dropColumn('sensor_id');
        });

        /*
        |--------------------------------------------------------------------------
        | T3950713
        |--------------------------------------------------------------------------
        */
        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->string('place_id')->nullable()->after('sensor_id');
        });

        Schema::table('station_T3950713', function (Blueprint $table) {
            $table->dropColumn('sensor_id');
        });

        /*
        |--------------------------------------------------------------------------
        | V0440346
        |--------------------------------------------------------------------------
        */
        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->string('place_id')->nullable()->after('sensor_id');
        });

        Schema::table('station_V0440346', function (Blueprint $table) {
            $table->dropColumn('sensor_id');
        });
    }
};
