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
        /*
        |--------------------------------------------------------------------------
        | сhlorine rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('chlorine_temp')->nullable()->after('сhlorine');
        });

        DB::statement('UPDATE split_measurement_ua171 SET chlorine_temp = сhlorine');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('сhlorine');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('chlorine')->nullable()->after('chlorine_temp');
        });

        DB::statement('UPDATE split_measurement_ua171 SET chlorine = chlorine_temp');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('chlorine_temp');
        });
        /*
        |--------------------------------------------------------------------------
        | сhlorine_ratio rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('chlorine_ratio_temp')->nullable()->after('сhlorine_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET chlorine_ratio_temp = сhlorine_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('сhlorine_ratio');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('chlorine_ratio')->nullable()->after('chlorine_ratio_temp');
        });

        DB::statement('UPDATE split_measurement_ua171 SET chlorine_ratio = chlorine_ratio_temp');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('chlorine_ratio_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | сhlorine rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('chlorine_temp')->nullable()->after('chlorine');
        });

        DB::statement('UPDATE split_measurement_ua171 SET chlorine_temp = chlorine');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('chlorine');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('сhlorine')->nullable()->after('chlorine_temp');
        });

        DB::statement('UPDATE split_measurement_ua171 SET сhlorine = chlorine_temp');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('chlorine_temp');
        });
        /*
        |--------------------------------------------------------------------------
        | сhlorine_ratio rename
        |--------------------------------------------------------------------------
        */
        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('chlorine_ratio_temp')->nullable()->after('chlorine_ratio');
        });

        DB::statement('UPDATE split_measurement_ua171 SET chlorine_ratio_temp = chlorine_ratio');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('chlorine_ratio');
        });

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->float('сhlorine_ratio')->nullable()->after('chlorine_ratio_temp');
        });

        DB::statement('UPDATE split_measurement_ua171 SET сhlorine_ratio = chlorine_ratio_temp');

        Schema::table('split_measurement_ua171', function (Blueprint $table) {
            $table->dropColumn('chlorine_ratio_temp');
        });
    }
};
