<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Check if the user_id column doesn't already exist
        if (!Schema::hasColumn('events', 'user_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop the foreign key and the column if it exists
        if (Schema::hasColumn('events', 'user_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
