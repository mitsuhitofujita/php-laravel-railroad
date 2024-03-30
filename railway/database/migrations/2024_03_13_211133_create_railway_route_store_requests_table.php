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
        Schema::create('railway_route_store_requests', function (Blueprint $table) {
            $table->id();
            $table->text('token')->unique('railway_route_store_request_1');
            $table->foreignId('railway_route_event_stream_id')->index('railway_route_store_request_2');

            $table->foreignId('railway_provider_id');
            $table->datetime('valid_from', 6);
            $table->text('name');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_route_event_stream_id')->references('id')->on('railway_route_event_streams');
            $table->foreign('railway_provider_id')->references('id')->on('railway_providers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('railway_route_store_requests');
    }
};
