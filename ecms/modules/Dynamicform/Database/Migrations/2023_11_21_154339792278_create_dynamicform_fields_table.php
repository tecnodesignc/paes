<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicformFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamicform__fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label')->index();
            $table->string('name')->nullable();
            $table->integer('type')->default(0);
            $table->boolean('required')->nullable()->default(false);
            $table->integer('order')->unsigned()->default(0);
            $table->text('selectable')->nullable();
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('dynamicform__forms')->onDelete('cascade');
            $table->integer('company_id')->unsigned()->nullable();
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
        Schema::table('dynamicform__fields', function (Blueprint $table) {
            $table->dropIndex(['form_id']);
        });
        Schema::dropIfExists('dynamicform__fields');
    }
}
