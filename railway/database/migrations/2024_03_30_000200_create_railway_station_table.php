<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_station_event_stream_id');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_station_event_stream_id')->references('id')->on('railway_station_event_streams');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_stations');
    }
};
