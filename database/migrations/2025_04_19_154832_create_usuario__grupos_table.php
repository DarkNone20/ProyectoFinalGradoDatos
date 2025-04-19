<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('Usuario_Grupo', function (Blueprint $table) {
            // Columnas principales
            $table->string('DocumentoId', 20);
            $table->integer('IdGrupo');
            $table->date('FechaAsignacion')->default(DB::raw('CURRENT_DATE'));
            
            // Columna ENUM para el Rol
            $table->enum('Rol', ['Estudiante', 'invitado', 'egresado', 'Profesor'])
                  ->default('Estudiante');
            
            // Clave primaria compuesta
            $table->primary(['DocumentoId', 'IdGrupo']);
            
            // Claves foráneas
            $table->foreign('DocumentoId')
                  ->references('DocumentoId')
                  ->on('usuarios')
                  ->onDelete('cascade');
                  
            $table->foreign('IdGrupo')
                  ->references('IdGrupo')
                  ->on('Grupos')
                  ->onDelete('cascade');
            
            // Configuración de motor y collation
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('Usuario_Grupo');
    }
};