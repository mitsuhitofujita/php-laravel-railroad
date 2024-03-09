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
        Schema::create('railway_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_stream_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('event_stream_id')->references('id')->on('railway_provider_event_streams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('railway_providers');
    }
};
