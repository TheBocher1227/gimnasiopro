<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $inicioMes = Carbon::now()->startOfMonth()->toDateString();
            $finMes = Carbon::now()->endOfMonth()->toDateString();
            $hoy = Carbon::now()->toDateString();

            // Stats cards
            $clientesActivos = Cliente::where('estado', 'activo')->count();
            $totalProductos = Producto::count();

            // Ingresos del mes (pagos + ventas)
            $ingresosPagos = Pago::whereBetween('fecha_pago', [$inicioMes, $finMes])->sum('monto');
            $ingresosVentas = Venta::whereBetween('fecha_venta', [$inicioMes, $finMes])->sum('total');
            $ingresosMes = $ingresosPagos + $ingresosVentas;

            // Ventas de hoy
            $ventasHoy = Venta::whereDate('fecha_venta', $hoy)->count();

            // Pagos del mes
            $pagosDelMes = Pago::whereBetween('fecha_pago', [$inicioMes, $finMes])->count();

            // Distribución de membresías (clientes activos)
            $membresias = Cliente::where('estado', 'activo')
                ->select('tipo_membresia', DB::raw('count(*) as total'))
                ->groupBy('tipo_membresia')
                ->pluck('total', 'tipo_membresia')
                ->toArray();

            $membresiaLabels = [];
            $membresiaData = [];
            $tiposNombres = [
                'mensual' => 'Mensual',
                'quincenal' => 'Quincenal',
                'semanal' => 'Semanal',
                'visita' => 'Visita',
            ];

            foreach ($membresias as $tipo => $total) {
                $membresiaLabels[] = $tiposNombres[$tipo] ?? ucfirst($tipo);
                $membresiaData[] = $total;
            }

            // Ingresos diarios del mes actual (para gráfica de barras)
            $ventasDiarias = Venta::whereBetween('fecha_venta', [$inicioMes, $finMes])
                ->select(DB::raw('DATE(fecha_venta) as dia'), DB::raw('SUM(total) as total'))
                ->groupBy('dia')
                ->pluck('total', 'dia')
                ->toArray();

            $pagosDiarios = Pago::whereBetween('fecha_pago', [$inicioMes, $finMes])
                ->select(DB::raw('DATE(fecha_pago) as dia'), DB::raw('SUM(monto) as total'))
                ->groupBy('dia')
                ->pluck('total', 'dia')
                ->toArray();

            // Agrupar por semana del mes
            $semanas = [];
            $inicio = Carbon::now()->startOfMonth();
            $fin = Carbon::now()->endOfMonth();
            $semanaNum = 1;

            while ($inicio->lte($fin)) {
                $finSemana = $inicio->copy()->endOfWeek()->min($fin);
                $label = 'Sem ' . $semanaNum;
                $totalSemana = 0;

                $current = $inicio->copy();
                while ($current->lte($finSemana)) {
                    $dia = $current->toDateString();
                    $totalSemana += ($ventasDiarias[$dia] ?? 0) + ($pagosDiarios[$dia] ?? 0);
                    $current->addDay();
                }

                $semanas[] = ['label' => $label, 'total' => round($totalSemana, 2)];
                $inicio = $finSemana->copy()->addDay();
                $semanaNum++;
            }

            $ingresosLabels = array_column($semanas, 'label');
            $ingresosData = array_column($semanas, 'total');

            // Últimos 5 pagos del mes
            $ultimosPagos = Pago::with('cliente')
                ->whereBetween('fecha_pago', [$inicioMes, $finMes])
                ->orderByDesc('fecha_pago')
                ->limit(5)
                ->get();

            // Últimas 5 ventas del mes
            $ultimasVentas = Venta::with('cliente')
                ->whereBetween('fecha_venta', [$inicioMes, $finMes])
                ->orderByDesc('fecha_venta')
                ->limit(5)
                ->get();

            return view('dashboard', compact(
                'clientesActivos',
                'totalProductos',
                'ingresosMes',
                'ventasHoy',
                'pagosDelMes',
                'membresiaLabels',
                'membresiaData',
                'ingresosLabels',
                'ingresosData',
                'ultimosPagos',
                'ultimasVentas'
            ));
        } catch (\Exception $e) {
            Log::error('Error en dashboard: ' . $e->getMessage());

            return view('dashboard', [
                'clientesActivos' => 0,
                'totalProductos' => 0,
                'ingresosMes' => 0,
                'ventasHoy' => 0,
                'pagosDelMes' => 0,
                'membresiaLabels' => [],
                'membresiaData' => [],
                'ingresosLabels' => [],
                'ingresosData' => [],
                'ultimosPagos' => collect(),
                'ultimasVentas' => collect(),
            ]);
        }
    }
}
