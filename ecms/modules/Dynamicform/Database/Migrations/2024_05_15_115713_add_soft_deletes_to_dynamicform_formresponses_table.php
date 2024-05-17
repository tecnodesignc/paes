<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToDynamicformFormresponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamicform__formresponses', function (Blueprint $table) {
            $table->softDeletes(); // Agrega la columna de soft deletes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dynamicform__formresponses', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Elimina la columna de soft deletes si es necesario revertir la migración
        });
    }
}
