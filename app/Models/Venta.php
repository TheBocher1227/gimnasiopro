<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'fecha_venta',
        'total',
        'forma_pago',
    ];

    protected $casts = [
        'total'       => 'decimal:2',
        'fecha_venta' => 'datetime',
    ];

    /**
     * Cliente que realizó la venta.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Detalles de la venta.
     */
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }
}
