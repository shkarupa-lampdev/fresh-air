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
        Schema::create('station1748', function (Blueprint $table) {
            $table->id();
            $table->integer('place_id');
            $table->date('measurement_time');
            $table->integer('split_number');
            $table->integer('measurement_ratio');
            $table->string('option');
            $table->string('measurement_unit');
            $table->float('measurement_value');

            $table->string('unique_hash')->unique()->index();

            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station1748');
    }
};
