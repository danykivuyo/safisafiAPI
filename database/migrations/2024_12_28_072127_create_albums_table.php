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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('type', ['song', 'audiobook', 'podcast']);
            $table->string('artist_name')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('genre')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('track_count')->nullable();
            $table->string('language', 50)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
