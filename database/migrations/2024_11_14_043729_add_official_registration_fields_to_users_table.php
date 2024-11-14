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
        Schema::table('users', function (Blueprint $table) {
            $table->string('type')->default('admin')->after('email'); // Add 'type' after 'email'
            $table->string('phone_number')->nullable()->after('type');
            $table->string('city')->nullable()->after('phone_number');
            $table->string('state')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'phone_number',
                'city',
                'state',
                'zip_code'
            ]);
        });
    }
};
