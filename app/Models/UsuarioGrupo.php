<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioGrupo extends Model
{
    use HasFactory;

    protected $table = 'Usuario_Grupo';

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'IdGrupo',
        'DocumentoId',
        'Rol',
        'FechaAsignacion'
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupos::class, 'IdGrupo');
    }

    public function usuario()
    {
        return $this->belongsTo(Users::class, 'DocumentoId');
    }
}
