<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->string('ActivoFijo', 20);
            $table->string('Serial', 20);
            $table->string('Marca', 45)->nullable();
            $table->string('Modelo', 45)->nullable();
            $table->string('SalaMovil', 45)->nullable();
            $table->string('Estado', 20);
            $table->timestamps();
            
            //  clave primaria compuesta
            $table->primary(['ActivoFijo', 'Serial']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipos');
    }
};