<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport__vehicles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('device_id')->nullable();
            $table->text('device')->nullable();
            $table->string('brand')->nullable();
            $table->string('plate')->nullable();
            $table->string('model')->nullable();
            $table->string('class')->nullable();
            $table->integer('mileage')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('sass__companies')->onDelete('cascade');

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
        Schema::table('transport__vehicles', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
        });
        Schema::dropIfExists('transport__vehicles');
    }
}
