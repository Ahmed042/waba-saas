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
    Schema::create('contacts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_id'); // For data isolation
        $table->string('name')->nullable();
        $table->string('phone')->unique();
        $table->timestamps();

        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
