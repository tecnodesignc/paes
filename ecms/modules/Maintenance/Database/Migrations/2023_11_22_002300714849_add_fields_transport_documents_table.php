<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transport__documents', function (Blueprint $table) {
            $table->date('expiration_date')->nullable();
            $table->double('amount',18,2)->nullable();
            $table->boolean('alert')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transport__vehicles', function (Blueprint $table) {
            $table->dropColumn(['type','reference','property_card','displacement','color','box_type','transmission_type','shielding','doors']);
        });

    }
};
