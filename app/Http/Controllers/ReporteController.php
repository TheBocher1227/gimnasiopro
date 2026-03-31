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

    /**
     * Corte de Caja.
     */
    public function corteCaja(Request $request)
    {
        $fecha = $request->get('fecha', Carbon::today()->toDateString());
        $formaPago = $request->get('forma_pago', 'todos');

        // Membresías (pagos)
        $pagosQuery = Pago::with('cliente')
            ->whereDate('fecha_pago', $fecha);

        if ($formaPago !== 'todos') {
            $pagosQuery->where('forma_pago', $formaPago);
        }

        $pagos = $pagosQuery->orderBy('id_pago', 'desc')->get();

        // Ventas de productos
        $ventasQuery = Venta::with('cliente')
            ->whereDate('fecha_venta', $fecha);

        if ($formaPago !== 'todos') {
            $ventasQuery->where('forma_pago', $formaPago);
        }

        $ventas = $ventasQuery->orderBy('id_venta', 'desc')->get();

        // Totales
        $totalMembresias = $pagos->sum('monto');
        $totalVentasProductos = $ventas->sum('total');
        $totalBruto = $totalMembresias + $totalVentasProductos;

        // Totales por método de pago (siempre del día completo para la card de métodos)
        $pagosDelDia = Pago::whereDate('fecha_pago', $fecha)->get();
        $ventasDelDia = Venta::whereDate('fecha_venta', $fecha)->get();

        $totalEfectivo = $pagosDelDia->where('forma_pago', 'efectivo')->sum('monto')
                       + $ventasDelDia->where('forma_pago', 'efectivo')->sum('total');

        $totalTarjeta = $pagosDelDia->where('forma_pago', 'tarjeta')->sum('monto')
                      + $ventasDelDia->where('forma_pago', 'tarjeta')->sum('total');

        return view('reportes.corte-caja', compact(
            'fecha',
            'formaPago',
            'pagos',
            'ventas',
            'totalMembresias',
            'totalVentasProductos',
            'totalBruto',
            'totalEfectivo',
            'totalTarjeta'
        ));
    }
}
