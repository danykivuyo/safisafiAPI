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
            $table->string('likes')->default(0)->change();
            $table->string('plays')->default(0)->change();
            $table->string('shares')->default(0)->change();
            $table->string('views')->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('podcasts', function (Blueprint $table) {
            //
            $table->string('likes')->default(null)->change();
            $table->string('plays')->default(null)->change();
            $table->string('shares')->default(null)->change();
            $table->string('views')->default(null)->change();
        });
    }
};
