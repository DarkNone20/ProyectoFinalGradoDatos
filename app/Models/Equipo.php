<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';
    
    // Deshabilitar auto-incremento ya que usamos claves primarias compuestas
    public $incrementing = false;
    
    protected $primaryKey = ['ActivoFijo', 'Serial'];
    
    protected $fillable = [
        'ActivoFijo',
        'Serial',
        'Marca',
        'Modelo',
        'SalaMovil',
        'Estado',
        'Disponibilidad'
    ];
    
    // Para que Laravel maneje correctamente las claves primarias compuestas
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('ActivoFijo', $this->getAttribute('ActivoFijo'))
                    ->where('Serial', $this->getAttribute('Serial'));
    }
}