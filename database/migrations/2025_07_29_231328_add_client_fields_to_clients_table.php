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
    Schema::table('clients', function (Blueprint $table) {
        if (!Schema::hasColumn('clients', 'type')) {
            $table->string('type')->default('official');
        }
        if (!Schema::hasColumn('clients', 'company')) {
            $table->string('company')->nullable();
        }
        // REMOVE phone since it already exists
        if (!Schema::hasColumn('clients', 'callback_url')) {
            $table->string('callback_url')->nullable();
        }
        if (!Schema::hasColumn('clients', 'phone_id')) {
            $table->string('phone_id')->nullable();
        }
        if (!Schema::hasColumn('clients', 'access_token')) {
            $table->string('access_token')->nullable();
        }
        if (!Schema::hasColumn('clients', 'number_wa')) {
            $table->string('number_wa')->nullable();
        }
        if (!Schema::hasColumn('clients', 'api')) {
            $table->string('api')->nullable();
        }
        if (!Schema::hasColumn('clients', 'role')) {
            $table->string('role')->default('client');
        }
    });
}

public function down()
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn([
            'type', 'company', 'callback_url',
            'phone_id', 'access_token', 'number_wa', 'api', 'role'
        ]);
    });
}

};
