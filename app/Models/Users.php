<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'Usuarios';
    protected $primaryKey = 'DocumentoId';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'DocumentoId',
        'Nombre',
        'Apellido',
        'Direccion',
        'Telefono',
        'Email',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
    // En el modelo Users (app/Models/Users.php)
    public function grupos()
    {
        return $this->belongsToMany(Grupos::class, 'Usuario_Grupo', 'DocumentoId', 'IdGrupo')
            ->using(UsuarioGrupo::class)
            ->withPivot(['Rol', 'FechaAsignacion']);
    }
}
