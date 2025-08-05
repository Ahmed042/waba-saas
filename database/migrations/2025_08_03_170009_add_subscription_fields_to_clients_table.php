<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('package_name')->nullable()->after('business_type');
            $table->integer('total_messages_allowed')->nullable()->after('package_name');
            $table->date('subscription_date')->nullable()->after('total_messages_allowed');
            $table->date('renewal_date')->nullable()->after('subscription_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('package_name');
            $table->dropColumn('total_messages_allowed');
            $table->dropColumn('subscription_date');
            $table->dropColumn('renewal_date');
        });
    }
}
