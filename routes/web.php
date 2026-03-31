<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;

use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirigir raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación (solo para invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (solo para autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect('/dashboard');
    })->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reportes
    Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('/reportes/pagos', [ReporteController::class, 'pagos'])->name('reportes.pagos');
    Route::get('/reportes/inventario', [ReporteController::class, 'inventario'])->name('reportes.inventario');
    Route::get('/reportes/clientes', [ReporteController::class, 'clientes'])->name('reportes.clientes');
    Route::get('/reportes/productos', [ReporteController::class, 'productos'])->name('reportes.productos');
    Route::get('/reportes/corte-caja', [ReporteController::class, 'corteCaja'])->name('reportes.corte-caja');

    // Exportaciones
    Route::get('/exportar/ventas/pdf', [ExportController::class, 'ventasPdf'])->name('exportar.ventas.pdf');
    Route::get('/exportar/ventas/excel', [ExportController::class, 'ventasExcel'])->name('exportar.ventas.excel');
    Route::get('/exportar/pagos/pdf', [ExportController::class, 'pagosPdf'])->name('exportar.pagos.pdf');
    Route::get('/exportar/pagos/excel', [ExportController::class, 'pagosExcel'])->name('exportar.pagos.excel');
    Route::get('/exportar/inventario/pdf', [ExportController::class, 'inventarioPdf'])->name('exportar.inventario.pdf');
    Route::get('/exportar/inventario/excel', [ExportController::class, 'inventarioExcel'])->name('exportar.inventario.excel');
    Route::get('/exportar/clientes/pdf', [ExportController::class, 'clientesPdf'])->name('exportar.clientes.pdf');
    Route::get('/exportar/clientes/excel', [ExportController::class, 'clientesExcel'])->name('exportar.clientes.excel');
    Route::get('/exportar/productos/pdf', [ExportController::class, 'productosPdf'])->name('exportar.productos.pdf');
    Route::get('/exportar/productos/excel', [ExportController::class, 'productosExcel'])->name('exportar.productos.excel');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
