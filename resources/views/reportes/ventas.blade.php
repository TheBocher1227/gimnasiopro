@extends('layouts.dashboard')

@section('title', 'Reporte de Ventas - Gimnasio Pro')
@section('page-title', 'Reporte de Ventas')

@section('styles')
    @include('partials.table-styles')
    @include('partials.table-controls')
    @include('partials.export-buttons')
@endsection

@section('content')
    <div class="page-header">
        <h1>Reporte de Ventas</h1>
        <p>Consulta las ventas realizadas por rango de fechas.</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('reportes.ventas') }}" class="filter-bar">
        <div class="filter-group">
            <label for="fecha_inicio">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="filter-input" value="{{ $fechaInicio }}">
        </div>
        <div class="filter-group">
            <label for="fecha_fin">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="filter-input" value="{{ $fechaFin }}">
        </div>
        <button type="submit" class="btn-filter">Filtrar</button>
    </form>

    {{-- Resumen --}}
    <div class="summary-row">
        <div class="summary-card">
            <div class="label">Total Ventas</div>
            <div class="value">${{ number_format($totalVentas, 2) }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Cantidad</div>
            <div class="value">{{ $ventas->count() }}</div>
        </div>
    </div>

    {{-- Tabla --}}
    @if ($ventas->count() > 0)
        <div class="table-controls-top">
            <div class="table-show">
                Mostrar
                <select id="tcPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                registros
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="export-buttons">
                    <a href="{{ route('exportar.ventas.pdf', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn-export pdf">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                        PDF
                    </a>
                    <a href="{{ route('exportar.ventas.excel', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn-export excel">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 13.125c0-.621.504-1.125 1.125-1.125" /></svg>
                        Excel
                    </a>
                </div>
                <div class="table-search">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    <input type="text" id="tcSearch" placeholder="Buscar...">
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table" id="dataTable">
                <thead>
                    <tr>
                        <th class="sortable" data-col="0">ID</th>
                        <th class="sortable" data-col="1">Cliente</th>
                        <th class="sortable" data-col="2">Fecha</th>
                        <th class="sortable" data-col="3">Forma Pago</th>
                        <th class="sortable text-right" data-col="4">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td class="text-bold">#{{ $venta->id_venta }}</td>
                            <td>{{ $venta->cliente->nombre ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>
                            <td><span class="badge badge-blue">{{ $venta->forma_pago }}</span></td>
                            <td class="text-right text-bold">${{ number_format($venta->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-controls-bottom">
            <div class="table-info" id="tcInfo"></div>
            <div class="table-pagination" id="tcPagination"></div>
        </div>
    @else
        <div class="table-wrapper">
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                <p>No hay ventas en el rango seleccionado.</p>
            </div>
        </div>
    @endif
@endsection
