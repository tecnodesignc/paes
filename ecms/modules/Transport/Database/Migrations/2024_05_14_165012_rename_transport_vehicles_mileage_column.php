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
        Schema::table('transport__vehicles', function (Blueprint $table) {
            $table->renameColumn('mileage', 'millage');
        });
    }

    public function down()
    {
        Schema::table('transport__vehicles', function (Blueprint $table) {
            $table->renameColumn('millage', 'mileage');
        });
    }
};
