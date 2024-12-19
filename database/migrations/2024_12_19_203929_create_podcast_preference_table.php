<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('podcast_preference', function (Blueprint $table) {
            $table->id();
            $table->foreignId('podcast_id')->constrained()->onDelete('cascade');
            $table->foreignId('preference_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['podcast_id', 'preference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podcast_preference');
    }
};
