<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;

    protected $table = 'grupos';
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
    
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('IdGrupo', $this->getAttribute('IdGrupo'));
    }
}