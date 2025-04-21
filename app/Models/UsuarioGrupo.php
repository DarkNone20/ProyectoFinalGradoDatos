<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class UsuarioGrupo extends Pivot
{
    protected $table = 'usuario_grupo';

    protected $fillable = [
        'DocumentoId',
        'IdGrupo',
        'Rol',
        'FechaAsignacion'
    ];
}
