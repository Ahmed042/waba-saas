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
    Schema::create('whatsapp_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('client_id')->nullable();
    $table->text('message')->nullable();
    $table->string('status')->nullable();
    $table->timestamps();

    $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
