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
        Schema::table('events', function (Blueprint $table) {
            $table->date('enddate')->nullable(); // enddate field
            $table->string('game_name')->nullable(); // game_name field
            $table->decimal('double_price', 8, 2)->nullable(); // double_price field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('enddate');
            $table->dropColumn('game_name');
            $table->dropColumn('double_price');
        });
    }
};
