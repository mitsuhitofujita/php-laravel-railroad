<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_station_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_station_id');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_station_id')->references('id')->on('railway_stations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_station_histories');
    }
};
