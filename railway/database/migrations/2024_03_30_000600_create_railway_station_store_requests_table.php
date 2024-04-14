<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_station_store_requests', function (Blueprint $table) {
            $table->id();
            $table->text('token')->unique('railway_station_store_request_1');
            $table->foreignId('railway_station_event_stream_id');

            $table->foreignId('railway_line_id');
            $table->datetime('valid_from', 6);
            $table->text('name');
            $table->text('nickname');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_station_event_stream_id')->references('id')->on('railway_station_event_streams');
            $table->foreign('railway_line_id')->references('id')->on('railway_lines');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_station_store_requests');
    }
};
