<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsuarioGrupo extends Pivot
{
    public $incrementing = false;
    protected $table = 'Usuario_Grupo';
    public $timestamps = false; // Esto desactiva la búsqueda de created_at y updated_at
    
    protected $fillable = [
        'DocumentoId',
        'IdGrupo',
        'FechaAsignacion',
        'Rol'
    ];
}
