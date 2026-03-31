<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\InventarioHistorial;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportController extends Controller
{
    // =========== VENTAS ===========

    public function ventasPdf(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $ventas = Venta::with('cliente')
            ->whereBetween('fecha_venta', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->orderByDesc('fecha_venta')
            ->get();

        $total = $ventas->sum('total');

        $pdf = Pdf::loadView('exports.ventas-pdf', compact('ventas', 'total', 'fechaInicio', 'fechaFin'));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->download('reporte_ventas_' . $fechaInicio . '_' . $fechaFin . '.pdf');
    }

    public function ventasExcel(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $ventas = Venta::with('cliente')
            ->whereBetween('fecha_venta', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->orderByDesc('fecha_venta')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ventas');

        $headers = ['ID', 'Cliente', 'Fecha', 'Forma Pago', 'Total'];
        $this->setHeaders($sheet, $headers);

        $row = 2;
        foreach ($ventas as $v) {
            $sheet->setCellValue('A' . $row, $v->id_venta);
            $sheet->setCellValue('B' . $row, $v->cliente->nombre ?? '—');
            $sheet->setCellValue('C' . $row, Carbon::parse($v->fecha_venta)->format('d/m/Y H:i'));
            $sheet->setCellValue('D' . $row, $v->forma_pago);
            $sheet->setCellValue('E' . $row, $v->total);
            $row++;
        }

        $this->autoSize($sheet, count($headers));
        return $this->downloadExcel($spreadsheet, 'reporte_ventas_' . $fechaInicio . '_' . $fechaFin);
    }

    // =========== PAGOS ===========

    public function pagosPdf(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $pagos = Pago::with('cliente')
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->orderByDesc('fecha_pago')
            ->get();

        $total = $pagos->sum('monto');

        $pdf = Pdf::loadView('exports.pagos-pdf', compact('pagos', 'total', 'fechaInicio', 'fechaFin'));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->download('reporte_pagos_' . $fechaInicio . '_' . $fechaFin . '.pdf');
    }

    public function pagosExcel(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $pagos = Pago::with('cliente')
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->orderByDesc('fecha_pago')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pagos');

        $headers = ['ID', 'Cliente', 'Fecha', 'Tipo Membresía', 'Forma Pago', 'Monto'];
        $this->setHeaders($sheet, $headers);

        $row = 2;
        foreach ($pagos as $p) {
            $sheet->setCellValue('A' . $row, $p->id_pago);
            $sheet->setCellValue('B' . $row, $p->cliente->nombre ?? '—');
            $sheet->setCellValue('C' . $row, Carbon::parse($p->fecha_pago)->format('d/m/Y'));
            $sheet->setCellValue('D' . $row, $p->tipo_membresia);
            $sheet->setCellValue('E' . $row, $p->forma_pago);
            $sheet->setCellValue('F' . $row, $p->monto);
            $row++;
        }

        $this->autoSize($sheet, count($headers));
        return $this->downloadExcel($spreadsheet, 'reporte_pagos_' . $fechaInicio . '_' . $fechaFin);
    }

    // =========== INVENTARIO ===========

    public function inventarioPdf(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $historial = InventarioHistorial::with('producto')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->orderByDesc('fecha')
            ->get();

        $pdf = Pdf::loadView('exports.inventario-pdf', compact('historial', 'fechaInicio', 'fechaFin'));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->download('historial_inventario_' . $fechaInicio . '_' . $fechaFin . '.pdf');
    }

    public function inventarioExcel(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::today()->toDateString());
        $fechaFin = $request->get('fecha_fin', Carbon::today()->toDateString());

        $historial = InventarioHistorial::with('producto')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->orderByDesc('fecha')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Inventario');

        $headers = ['ID', 'Producto', 'Tipo', 'Cantidad', 'Motivo', 'Fecha', 'Stock Anterior', 'Stock Nuevo'];
        $this->setHeaders($sheet, $headers);

        $row = 2;
        foreach ($historial as $m) {
            $sheet->setCellValue('A' . $row, $m->id_historial);
            $sheet->setCellValue('B' . $row, $m->producto->nombre ?? '—');
            $sheet->setCellValue('C' . $row, $m->tipo);
            $sheet->setCellValue('D' . $row, $m->cantidad);
            $sheet->setCellValue('E' . $row, $m->motivo);
            $sheet->setCellValue('F' . $row, Carbon::parse($m->fecha)->format('d/m/Y H:i'));
            $sheet->setCellValue('G' . $row, $m->stock_anterior);
            $sheet->setCellValue('H' . $row, $m->stock_nuevo);
            $row++;
        }

        $this->autoSize($sheet, count($headers));
        return $this->downloadExcel($spreadsheet, 'historial_inventario_' . $fechaInicio . '_' . $fechaFin);
    }

    // =========== CLIENTES ===========

    public function clientesPdf()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        $pdf = Pdf::loadView('exports.clientes-pdf', compact('clientes'));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->download('clientes_' . Carbon::today()->toDateString() . '.pdf');
    }

    public function clientesExcel()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Clientes');

        $headers = ['ID', 'Nombre', 'Correo', 'Teléfono', 'Membresía', 'Estado'];
        $this->setHeaders($sheet, $headers);

        $row = 2;
        foreach ($clientes as $c) {
            $sheet->setCellValue('A' . $row, $c->id_cliente);
            $sheet->setCellValue('B' . $row, $c->nombre);
            $sheet->setCellValue('C' . $row, $c->correo ?? '—');
            $sheet->setCellValue('D' . $row, $c->telefono ?? '—');
            $sheet->setCellValue('E' . $row, $c->tipo_membresia);
            $sheet->setCellValue('F' . $row, $c->estado);
            $row++;
        }

        $this->autoSize($sheet, count($headers));
        return $this->downloadExcel($spreadsheet, 'clientes_' . Carbon::today()->toDateString());
    }

    // =========== PRODUCTOS ===========

    public function productosPdf()
    {
        $productos = Producto::orderBy('nombre')->get();

        $pdf = Pdf::loadView('exports.productos-pdf', compact('productos'));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->download('productos_' . Carbon::today()->toDateString() . '.pdf');
    }

    public function productosExcel()
    {
        $productos = Producto::orderBy('nombre')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Productos');

        $headers = ['ID', 'Código', 'Nombre', 'Descripción', 'Precio', 'Stock'];
        $this->setHeaders($sheet, $headers);

        $row = 2;
        foreach ($productos as $p) {
            $sheet->setCellValue('A' . $row, $p->id_producto);
            $sheet->setCellValue('B' . $row, $p->codigo_barras);
            $sheet->setCellValue('C' . $row, $p->nombre);
            $sheet->setCellValue('D' . $row, $p->descripcion);
            $sheet->setCellValue('E' . $row, $p->precio);
            $sheet->setCellValue('F' . $row, $p->stock);
            $row++;
        }

        $this->autoSize($sheet, count($headers));
        return $this->downloadExcel($spreadsheet, 'productos_' . Carbon::today()->toDateString());
    }

    // =========== HELPERS ===========

    private function setHeaders($sheet, array $headers)
    {
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '111827']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $col++;
        }
    }

    private function autoSize($sheet, int $colCount)
    {
        $col = 'A';
        for ($i = 0; $i < $colCount; $i++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }
    }

    private function downloadExcel(Spreadsheet $spreadsheet, string $filename)
    {
        $writer = new Xlsx($spreadsheet);
        $temp = tempnam(sys_get_temp_dir(), 'xlsx');
        $writer->save($temp);

        return response()->download($temp, $filename . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
