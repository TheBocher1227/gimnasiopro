@extends('layouts.dashboard')

@section('title', 'Historial de Inventario - Gimnasio Pro')
@section('page-title', 'Historial de Inventario')

@section('styles')
    @include('partials.table-styles')
    @include('partials.table-controls')
    @include('partials.export-buttons')
@endsection

@section('content')
    <div class="page-header">
        <h1>Historial de Inventario</h1>
        <p>Movimientos de entrada y salida de productos.</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('reportes.inventario') }}" class="filter-bar">
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

    {{-- Tabla --}}
    @if ($historial->count() > 0)
        <div class="table-controls-top">
            <div class="table-show">
                Mostrar
                <select id="tcPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                registros
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="export-buttons">
                    <a href="{{ route('exportar.inventario.pdf', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn-export pdf"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg> PDF</a>
                    <a href="{{ route('exportar.inventario.excel', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn-export excel"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125" /></svg> Excel</a>
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
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th class="text-right">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historial as $mov)
                        <tr>
                            <td class="text-bold">#{{ $mov->id_historial }}</td>
                            <td class="text-bold">{{ $mov->producto->nombre ?? '—' }}</td>
                            <td>
                                @if ($mov->tipo === 'entrada')
                                    <span class="badge badge-green">entrada</span>
                                @else
                                    <span class="badge badge-red">salida</span>
                                @endif
                            </td>
                            <td>{{ $mov->cantidad }}</td>
                            <td>{{ $mov->motivo }}</td>
                            <td>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y H:i') }}</td>
                            <td class="text-right">
                                <span class="text-muted">{{ $mov->stock_anterior }}</span>
                                →
                                <span class="text-bold">{{ $mov->stock_nuevo }}</span>
                            </td>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p>No hay movimientos en el rango seleccionado.</p>
            </div>
        </div>
    @endif
@endsection
