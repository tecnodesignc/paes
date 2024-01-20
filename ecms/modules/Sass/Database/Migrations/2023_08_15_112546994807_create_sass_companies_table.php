<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSassCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sass__companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('logo')->nullable();
            $table->text('name')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('identification')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->integer('type')->default(1);
            $table->text('settings');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('sass__companies');
    }
}
