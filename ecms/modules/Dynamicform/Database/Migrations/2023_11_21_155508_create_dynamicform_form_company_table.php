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
        Schema::create('dynamicform__form_company', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->boolean('active')->default(1);
            $table->boolean('send_confirmation')->default(0);
            $table->foreign('form_id')->references('id')->on('dynamicform__forms')->onDelete('cascade');
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
        Schema::table('dynamicform__form_company', function (Blueprint $table) {
            $table->dropIndex(['form_id','company_id']);
        });
        Schema::dropIfExists('dynamicform__form_company');
    }
};
