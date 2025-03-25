<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioAdmin extends Authenticatable
{
    use HasFactory;

    protected $table = 'UsuariosAdmin'; // Nombre de la tabla
    protected $primaryKey = 'Cedula';  // Clave primaria
    public $incrementing = false;      // La clave primaria no es autoincremental
    protected $keyType = 'string';     // Tipo de la clave primaria

    protected $fillable = [
        'Cedula',
        'Alias',
        'Nombre',
        'Password',
        'Cargo',
    ];

    protected $hidden = [
        'Password',
    ];
}