<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo_barras',
        'nombre',
        'descripcion',
        'precio',
        'stock',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock'  => 'integer',
    ];

    /**
     * Detalles de venta donde aparece este producto.
     */
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_producto', 'id_producto');
    }

    /**
     * Historial de inventario del producto.
     */
    public function historialInventario()
    {
        return $this->hasMany(InventarioHistorial::class, 'id_producto', 'id_producto');
    }
}
