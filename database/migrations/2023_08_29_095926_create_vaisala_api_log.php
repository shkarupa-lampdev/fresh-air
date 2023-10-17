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
        Schema::create('vaisala_api_log', function (Blueprint $table) {
            $table->id();
            $table->string('station_id');
            $table->string('sensor_id');
            $table->string('status');
            $table->string('error_message')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaisala_api_log');
    }
};
