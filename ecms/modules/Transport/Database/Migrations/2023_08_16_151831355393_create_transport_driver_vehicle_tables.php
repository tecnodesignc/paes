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
        Schema::create('transport__driver_vehicle', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('transport__drivers')->onDelete('cascade');
            $table->integer('vehicle_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('transport__vehicles')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transport__driver_vehicle', function (Blueprint $table) {
            $table->dropIndex(['driver_id','vehicle_id']);
        });
        Schema::dropIfExists('transport__driver_vehicle');
    }
};
