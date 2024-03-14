<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('dynamicform__fields', function (Blueprint $table) {
           $table->integer('finding')->nullable();
       });
    }

    public function down()
    {
       Schema::table('dynamicform__fields', function (Blueprint $table) {
            $table->dropColumn('finding');
       });
    }

};
