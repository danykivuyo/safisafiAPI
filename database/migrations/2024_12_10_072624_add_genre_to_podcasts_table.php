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
        Schema::table('podcasts', function (Blueprint $table) {
            //
            $table->string('genre1')->after('image_url');
            $table->string('genre2')->after('genre1');
            $table->string('likes')->after('genre2');
            $table->string('plays')->after('likes');
            $table->string('shares')->after('plays');
            $table->string('views')->after('shares');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('podcasts', function (Blueprint $table) {
            //
            $table->dropColumn(['genre1', 'genre2', 'likes', 'plays', 'shares', 'views']);
        });
    }
};
