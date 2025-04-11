<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioAdmin extends Authenticatable
{
    use HasFactory;

    protected $table = 'UsuariosAdmin';
    protected $primaryKey = 'Cedula';
    public $incrementing = false;
    protected $keyType = 'string';

    // Añade esta línea para desactivar timestamps
    public $timestamps = false;

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