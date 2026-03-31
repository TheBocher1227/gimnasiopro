<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioHistorial extends Model
{
    protected $table = 'inventario_historial';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'tipo',
        'cantidad',
        'motivo',
        'fecha',
        'stock_anterior',
        'stock_nuevo',
    ];

    protected $casts = [
        'cantidad'       => 'integer',
        'stock_anterior' => 'integer',
        'stock_nuevo'    => 'integer',
        'fecha'          => 'datetime',
    ];

    /**
     * Producto asociado al historial.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
