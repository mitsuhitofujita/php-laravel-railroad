<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_station_history_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_station_history_id');
            $table->foreignId('railway_station_detail_id');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_station_history_id')->references('id')->on('railway_station_histories');
            $table->foreign('railway_station_detail_id')->references('id')->on('railway_station_details');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_station_history_details');
    }
};
