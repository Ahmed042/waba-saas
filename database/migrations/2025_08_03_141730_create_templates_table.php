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
        Schema::create('templates', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('client_id');
    $table->string('meta_id')->nullable(); // Meta template ID
    $table->string('name');
    $table->string('language');
    $table->text('body');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->text('meta_response')->nullable(); // Raw response from Meta if needed
    $table->timestamps();

    $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
