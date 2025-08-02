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
    Schema::table('clients', function (Illuminate\Database\Schema\Blueprint $table) {
        if (!Schema::hasColumn('clients', 'password')) {
            $table->string('password');
        }
    });
}

public function down()
{
    Schema::table('clients', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn('password');
    });
}

};
