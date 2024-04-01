<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_station_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_route_id');
            $table->datetime('valid_from', 6);
            $table->text('name');
            $table->text('nickname');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_route_id')->references('id')->on('railway_routes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_station_details');
    }
};
