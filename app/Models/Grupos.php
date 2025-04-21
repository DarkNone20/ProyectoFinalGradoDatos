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



// app/Models/Grupo.php

public function usuarios()
{
    return $this->belongsToMany(
        Users::class,
        'usuario_grupo',
        'IdGrupo',
        'DocumentoId'
    )->using(UsuarioGrupo::class);
}
}
