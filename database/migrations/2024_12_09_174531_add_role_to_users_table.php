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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('mobile_number')->after('password');
            $table->string('role')->default('client')->after('mobile_number');
            $table->string('preference1')->nullable()->after('role');
            $table->string('preference2')->nullable()->after('preference1');
            $table->string('preference3')->nullable()->after('preference2');
            $table->string('preference4')->nullable()->after('preference3');
            $table->string('subscription')->default("0")->after('preference4');
            $table->string('country')->nullable()->after('subscription');
            $table->string('region')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['mobile_number', 'role', 'preference1', 'preference2', 'preference3', 'preference4', 'subscription', 'country', 'region']);
        });
    }
};
