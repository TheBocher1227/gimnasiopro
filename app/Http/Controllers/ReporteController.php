<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\InventarioHistorial;
use App\Models\Cliente;
use App\Models\Producto;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Reporte de Ventas.
     */
    public function ventas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $ventas = Venta::with(['cliente', 'detalles.producto'])
            ->whereDate('fecha_venta', '>=', $fechaInicio)
            ->whereDate('fecha_venta', '<=', $fechaFin)
            ->orderBy('fecha_venta', 'desc')
            ->get();

        $totalVentas = $ventas->sum('total');

        return view('reportes.ventas', compact('ventas', 'fechaInicio', 'fechaFin', 'totalVentas'));
    }

    /**
     * Reporte de Pagos.
     */
    public function pagos(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $pagos = Pago::with('cliente')
            ->whereDate('fecha_pago', '>=', $fechaInicio)
            ->whereDate('fecha_pago', '<=', $fechaFin)
            ->orderBy('fecha_pago', 'desc')
            ->get();

        $totalPagos = $pagos->sum('monto');

        return view('reportes.pagos', compact('pagos', 'fechaInicio', 'fechaFin', 'totalPagos'));
    }

    /**
     * Historial de Inventario.
     */
    public function inventario(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $historial = InventarioHistorial::with('producto')
            ->whereDate('fecha', '>=', $fechaInicio)
            ->whereDate('fecha', '<=', $fechaFin)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('reportes.inventario', compact('historial', 'fechaInicio', 'fechaFin'));
    }

    /**
     * Lista de Clientes.
     */
    public function clientes()
    {
        $clientes = Cliente::orderBy('nombre', 'asc')->get();

        return view('reportes.clientes', compact('clientes'));
    }

    /**
     * Lista de Productos.
     */
    public function productos()
    {
        $productos = Producto::orderBy('nombre', 'asc')->get();

        return view('reportes.productos', compact('productos'));
    }
}
