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
        Schema::table('transport__vehicles', function (Blueprint $table) {
            $table->integer('type')->nullable();
            $table->string('reference')->nullable();
            $table->string('property_card')->nullable();
            $table->string('displacement')->nullable();
            $table->string('color')->nullable();
            $table->integer('box_type')->default(0);
            $table->integer('transmission_type')->default(0);
            $table->boolean('shielding')->default(0);
            $table->integer('doors')->default(2);
            $table->string('serial_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->text('accessories')->nullable();
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
