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
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('business_name')->nullable();
        $table->string('country')->nullable();
        $table->string('type')->default('official');
$table->string('company')->nullable();
$table->string('phone')->nullable();
$table->string('callback_url')->nullable();
$table->string('phone_id')->nullable();
$table->string('access_token')->nullable();
$table->string('number_wa')->nullable();
$table->string('api')->nullable();
$table->string('role')->default('client');


        // WhatsApp API Info
        $table->enum('api_type', ['official', 'unofficial']);
        $table->json('api_credentials')->nullable(); // store WABA or instance info

        // Plan & Access
        $table->string('bot_type')->nullable(); // sales / support / custom
        $table->string('business_type')->nullable(); // agency / ecommerce / clinic etc.
        $table->enum('status', ['active', 'trial', 'suspended'])->default('trial');

        // Feature toggles
        $table->boolean('can_broadcast')->default(false);
        $table->boolean('can_use_groups')->default(false);
        $table->boolean('can_use_voice')->default(false);
        $table->boolean('can_use_flows')->default(false);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
