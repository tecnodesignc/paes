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
        Schema::table('transport__vehicles', function (Blueprint $table) {
            // Primero eliminamos la clave foránea existente
            $table->dropForeign(['company_id']);

            // Luego la volvemos a crear con la regla de restricción `RESTRICT`
            $table->foreign('company_id')
                  ->references('id')
                  ->on('sass__companies')
                  ->onDelete('restrict'); // La regla de restricción

            // Alternativamente, si 'restrict' no funciona debido a la implementación de la base de datos:
            // ->onDelete('no action');
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
            // Volvemos a eliminar la clave foránea actualizada
            $table->dropForeign(['company_id']);

            // La recreamos con la regla anterior, si es que existía
            $table->foreign('company_id')
                  ->references('id')
                  ->on('sass__companies')
                  ->onDelete('cascade'); // Regla anterior
        });
    }
};
