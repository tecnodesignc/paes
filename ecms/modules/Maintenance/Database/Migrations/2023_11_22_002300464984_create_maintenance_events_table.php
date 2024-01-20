<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance__events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('type')->default(0);
            $table->string('description')->nullable();
            $table->dateTime('alert')->nullable();
            $table->boolean('alert_active')->default(0);
            $table->integer('status')->default(0);
            $table->text('limits')->nullable();
            $table->text('form_verify')->nullable();
            $table->integer('eventable_id');
            $table->string('eventable_type');
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
        Schema::table('maintenance__events', function (Blueprint $table) {
            $table->dropIndex(['company_id',]);
        });
        Schema::dropIfExists('maintenance__events');
    }
}
