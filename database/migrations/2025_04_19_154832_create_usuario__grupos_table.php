<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Usuario_Grupo', function (Blueprint $table) {
            $table->string('IdGrupo');
            $table->string('DocumentoId');
            $table->string('Rol');
            $table->date('FechaAsignacion');
            $table->foreign('IdGrupo')->references('IdGrupo')->on('Grupos');
            $table->foreign('DocumentoId')->references('DocumentoId')->on('Usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Usuario_Grupo');
    }
};
