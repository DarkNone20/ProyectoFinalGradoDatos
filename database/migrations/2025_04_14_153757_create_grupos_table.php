<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->integer('IdGrupo')->primary(); // Cambiado a integer
            $table->string('NombreProfesor', 45)->notNull();
            $table->string('NombreCurso', 45)->nullable();
            $table->date('FechaInicial')->nullable();
            $table->date('FechaFinal')->nullable();
            $table->time('HoraInicial')->nullable();
            $table->time('HoraFinal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupos');
    }
};