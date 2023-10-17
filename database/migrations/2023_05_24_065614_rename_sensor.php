<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_eco_city', function (Blueprint $table) {
            $table->string('measurement_sensor')->after('measurement_data');
        });

        DB::statement('UPDATE data_eco_city SET measurement_sensor = measurement_data');

        Schema::table('data_eco_city', function (Blueprint $table) {
            $table->dropColumn('measurement_data');
        });

        Schema::table('data_eco_city', function (Blueprint $table) {
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_eco_city', function (Blueprint $table) {
            $table->string('measurement_data')->after('measurement_sensor');
        });

        DB::statement('UPDATE data_eco_city SET measurement_data = measurement_sensor');

        Schema::table('data_eco_city', function (Blueprint $table) {
            $table->dropColumn('measurement_sensor');
        });

        Schema::table('data_eco_city', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
