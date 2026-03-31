@extends('layouts.dashboard')

@section('title', 'Reporte de Pagos - Gimnasio Pro')
@section('page-title', 'Reporte de Pagos')

@section('styles')
    @include('partials.table-styles')
    @include('partials.table-controls')
    @include('partials.export-buttons')
@endsection

@section('content')
    <div class="page-header">
        <h1>Reporte de Pagos</h1>
        <p>Consulta los pagos de membresías registrados.</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('reportes.pagos') }}" class="filter-bar">
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
            <div class="label">Total Cobrado</div>
            <div class="value">${{ number_format($totalPagos, 2) }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Pagos Registrados</div>
            <div class="value">{{ $pagos->count() }}</div>
        </div>
    </div>

    {{-- Tabla --}}
    @if ($pagos->count() > 0)
        <div class="table-controls-top">
            <div class="table-show">
                Mostrar
                <select id="tcPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                registros
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="export-buttons">
                    <a href="{{ route('exportar.pagos.pdf', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn-export pdf"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg> PDF</a>
                    <a href="{{ route('exportar.pagos.excel', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn-export excel"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125" /></svg> Excel</a>
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
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Tipo Membresía</th>
                        <th>Forma Pago</th>
                        <th class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td class="text-bold">#{{ $pago->id_pago }}</td>
                            <td>{{ $pago->cliente->nombre ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-purple">{{ $pago->tipo_membresia }}</span></td>
                            <td><span class="badge badge-blue">{{ $pago->forma_pago }}</span></td>
                            <td class="text-right text-bold">${{ number_format($pago->monto, 2) }}</td>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                <p>No hay pagos en el rango seleccionado.</p>
            </div>
        </div>
    @endif
@endsection
