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
        Schema::create('recent_plays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('podcast_id')->constrained('podcasts')->onDelete('cascade'); // Foreign key to podcasts
            $table->string('user_id')->nullable(); // Nullable for anonymous users
            $table->timestamp('played_at')->default(DB::raw('CURRENT_TIMESTAMP')); // Timestamp of play
            $table->string('device')->nullable(); // Optional field to track the device used
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recent_plays');
    }
};
