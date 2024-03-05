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
        Schema::create('railway_provider_requests', function (Blueprint $table) {
            $table->id();
            $table->text('token')->unique();
            $table->uuid('resource_uuid')->unique();
            $table->text('action');
            $table->foreignId('railway_provider_id')->nullable();
            $table->text('name');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('railway_provider_requests');
    }
};
