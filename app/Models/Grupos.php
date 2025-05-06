<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;

    protected $table = 'Grupos';
    protected $primaryKey = 'IdGrupo';
    public $incrementing = false;
    protected $keyType = 'integer';
    public $timestamps = false;

    protected $fillable = [
        'IdGrupo',
        'NombreProfesor',
        'NombreCurso',
        'FechaInicial',
        'FechaFinal',
        'HoraInicial',
        'HoraFinal',
        'DiaSemana',
        'SalaMovil',
        'Duracion'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            Users::class,
            'usuario_grupo',
            'IdGrupo',
            'DocumentoId'
        )->withPivot('Rol', 'FechaAsignacion')
         ->using(UsuarioGrupo::class);
    }

    public function usuarios_count()
    {
        return $this->usuarios()->count();
    }
}