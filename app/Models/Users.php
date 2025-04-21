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


    // app/Models/Usuario.php

    public function grupos()
    {
        return $this->belongsToMany(
            Grupos::class,
            'usuario_grupo',
            'DocumentoId',
            'IdGrupo'
        )->using(UsuarioGrupo::class);
    }
}
