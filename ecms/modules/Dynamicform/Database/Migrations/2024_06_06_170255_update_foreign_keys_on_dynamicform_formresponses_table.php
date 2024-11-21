<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysOnDynamicformFormresponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamicform__formresponses', function (Blueprint $table) {
            // Elimina la clave externa existente
            $table->dropForeign(['form_id']);

            // Agrega la nueva clave externa con restricción restrict
            $table->foreign('form_id')
                  ->references('id')
                  ->on('dynamicform__forms')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
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
            // Elimina la nueva clave externa
            $table->dropForeign(['form_id']);

            // Restaura la clave externa anterior si es necesario
            $table->foreign('form_id')
                  ->references('id')
                  ->on('dynamicform__forms')
                  ->onDelete('cascade');
        });
    }
}
