<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;

    protected $table = 'Grupos'; // Nota: en MySQL el nombre es case-sensitive
    protected $primaryKey = 'IdGrupo';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'IdGrupo',
        'NombreProfesor',
        'NombreCurso',
        'FechaInicial',
        'FechaFinal',
        'HoraInicial',
        'HoraFinal'
    ];

    // Relación con usuarios a través de la tabla pivote

    // En el modelo Grupos (app/Models/Grupos.php)
    public function usuarios()
    {
        return $this->belongsToMany(Users::class, 'Usuario_Grupo', 'IdGrupo', 'DocumentoId')
            ->using(UsuarioGrupo::class)
            ->withPivot(['Rol', 'FechaAsignacion']);
    }
}
