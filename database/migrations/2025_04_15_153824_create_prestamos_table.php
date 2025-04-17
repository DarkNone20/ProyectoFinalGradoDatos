<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Prestamos', function (Blueprint $table) {
            $table->increments('IdPrestamo'); // Cambiado a increments para autoincremental
            $table->string('Serial', 20);
            $table->string('ActivoFijo', 20);
            $table->integer('GrupoId');
            $table->string('DocumentoId', 20);
            $table->string('SalaMovil', 45)->nullable();
            $table->date('FechaI');
            $table->date('FechaF');
            $table->time('HoraI');
            $table->time('HoraF');
            $table->integer('Duracion');
            
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('Prestamos');
    }
};