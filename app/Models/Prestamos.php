<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestamos extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Prestamos';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'IdPrestamo';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'IdPrestamo',
        'Serial',
        'ActivoFijo',
        'GrupoId',
        'DocumentoId',
        'SalaMovil',
        'FechaI',
        'FechaF',
        'HoraI',
        'HoraF',
        'Duracion',
        'FechaDevolucion',
        'HoraDevolucion',
        'Observaciones',
        'Estado'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
  protected $casts = [
    // Trata las columnas de fecha como objetos Carbon completos.
    'FechaI' => 'datetime',
    'FechaF' => 'datetime',
    'FechaDevolucion' => 'datetime',
    

    'Estado' => 'string'
];
    /**
     * Get the equipo associated with the prestamo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'Serial', 'Serial');
    }

    /**
     * Get the grupo that owns the prestamo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupos::class, 'GrupoId', 'IdGrupo');
    }

    /**
     * Get the usuario that owns the prestamo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'DocumentoId', 'DocumentoId');
    }

    /**
     * Scope a query to only include active loans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivos($query)
    {
        return $query->where('Estado', 'Activo')
                    ->orWhereNull('FechaDevolucion');
    }

    /**
     * Scope a query to only include returned loans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDevueltos($query)
    {
        return $query->where('Estado', 'Devuelto')
                    ->whereNotNull('FechaDevolucion');
    }

    /**
     * Scope a query to filter by serial.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $serial
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSerial($query, $serial)
    {
        return $query->where('Serial', 'like', '%'.$serial.'%');
    }

    /**
     * Scope a query to filter by document ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $documentoId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDocumentoId($query, $documentoId)
    {
        return $query->where('DocumentoId', $documentoId);
    }

    /**
     * Scope a query to filter by state.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithEstado($query, $estado)
    {
        return $query->where('Estado', $estado);
    }

    /**
     * Get the prestamo's duration in hours.
     *
     * @return float
     */
    public function getDuracionEnHorasAttribute()
    {
        return $this->Duracion / 60;
    }

    /**
     * Check if the loan is active.
     *
     * @return bool
     */
    public function estaActivo()
    {
        return $this->Estado === 'Activo' && is_null($this->FechaDevolucion);
    }

    /**
     * Check if the loan is returned.
     *
     * @return bool
     */
    public function estaDevuelto()
    {
        return $this->Estado === 'Devuelto' && !is_null($this->FechaDevolucion);
    }
}