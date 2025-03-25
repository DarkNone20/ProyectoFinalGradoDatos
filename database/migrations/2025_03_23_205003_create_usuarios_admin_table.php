<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosAdminTable extends Migration
{
    public function up()
    {
        Schema::create('UsuariosAdmin', function (Blueprint $table) {
            $table->string('Cedula', 20)->primary(); // Clave primaria
            $table->string('Alias', 20)->nullable();
            $table->string('Nombre', 45);
            $table->string('Password', 45);
            $table->string('Cargo', 20);
            $table->timestamps(); // Opcional: añade created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('UsuariosAdmin');
    }
}