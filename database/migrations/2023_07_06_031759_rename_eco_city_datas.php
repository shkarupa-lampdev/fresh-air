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
        Schema::rename('data_eco_city_1756', 'station1756');

        Schema::rename('data_eco_city_1753', 'station1753');

        Schema::table('station1753', function (Blueprint $table) {
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('station1753', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::rename('station1753', 'data_eco_city_1753');

        Schema::rename('station1756', 'data_eco_city_1756');
    }
};
