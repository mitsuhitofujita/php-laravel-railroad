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
        Schema::create('railway_line_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_line_id');
            $table->datetime('created_at', 6)->useCurrent();

            $table->foreign('railway_line_id')->references('id')->on('railway_lines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('railway_line_histories');
    }
};
