<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->string('DocumentoId', 20)->primary();
            $table->string('Nombre', 45);
            $table->string('Apellido', 45)->nullable();
            $table->string('Direccion', 100)->nullable();
            $table->string('Telefono', 15)->nullable();
            $table->string('Email', 100)->unique();
            $table->string('password', 255);
            
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('Usuarios');
    }
};