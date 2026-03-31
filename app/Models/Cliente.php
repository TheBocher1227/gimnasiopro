<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'numero',
        'tipo_membresia',
        'huella_id',
        'rostro_encoding',
        'estado',
    ];

    /**
     * Membresías hardcoded.
     */
    const MEMBRESIAS = [
        '1' => ['nombre' => 'mensual',   'precio' => 500.00],
        '2' => ['nombre' => 'quincenal', 'precio' => 300.00],
        '3' => ['nombre' => 'semanal',   'precio' => 150.00],
        '4' => ['nombre' => 'visita',    'precio' => 50.00],
    ];

    /**
     * Obtener el nombre de la membresía.
     */
    public function getNombreMembresiaAttribute()
    {
        return self::MEMBRESIAS[$this->tipo_membresia]['nombre'] ?? $this->tipo_membresia;
    }

    /**
     * Obtener el precio de la membresía.
     */
    public function getPrecioMembresiaAttribute()
    {
        return self::MEMBRESIAS[$this->tipo_membresia]['precio'] ?? 0;
    }

    /**
     * Pagos del cliente.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Ventas del cliente.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_cliente', 'id_cliente');
    }
}
