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
        Schema::create('railway_route_history_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_route_history_id');
            $table->foreignId('railway_route_detail_id');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_route_history_id')->references('id')->on('railway_route_histories');
            $table->foreign('railway_route_detail_id')->references('id')->on('railway_route_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('railway_route_history_details');
    }
};
