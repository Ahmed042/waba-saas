<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTemplatesStatusEnum extends Migration
{
    public function up()
    {
        // Works in Laravel 8+, with doctrine/dbal package installed
        Schema::table('templates', function (Blueprint $table) {
            $table->enum('status', [
                'pending_review',
                'pending',
                'approved',
                'rejected'
            ])->default('pending_review')->change();
        });
    }

    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending')->change();
        });
    }
}
