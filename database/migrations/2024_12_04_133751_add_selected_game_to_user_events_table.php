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
        Schema::table('user_events', function (Blueprint $table) {
            $table->string('selected_game')->nullable(); // Using string as it stores a simple formatted text like 'singles|200.00'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_events', function (Blueprint $table) {
            $table->dropColumn('selected_game');

        });
    }
};
