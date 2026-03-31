@extends('layouts.dashboard')

@section('title', 'Clientes - Gimnasio Pro')
@section('page-title', 'Clientes')

@section('styles')
    @include('partials.table-styles')
    @include('partials.table-controls')
    @include('partials.export-buttons')
@endsection

@section('content')
    <div class="page-header">
        <h1>Directorio de Clientes</h1>
        <p>Lista completa de clientes registrados.</p>
    </div>

    {{-- Resumen --}}
    <div class="summary-row">
        <div class="summary-card">
            <div class="label">Total Clientes</div>
            <div class="value">{{ $clientes->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Activos</div>
            <div class="value">{{ $clientes->where('estado', 'activo')->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Inactivos</div>
            <div class="value">{{ $clientes->where('estado', 'inactivo')->count() }}</div>
        </div>
    </div>

    {{-- Tabla --}}
    @if ($clientes->count() > 0)
        <div class="table-controls-top">
            <div class="table-show">
                Mostrar
                <select id="tcPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                registros
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="export-buttons">
                    <a href="{{ route('exportar.clientes.pdf') }}" class="btn-export pdf"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg> PDF</a>
                    <a href="{{ route('exportar.clientes.excel') }}" class="btn-export excel"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125" /></svg> Excel</a>
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
                        <th class="sortable" data-col="1">Nombre</th>
                        <th class="sortable" data-col="2">Correo</th>
                        <th class="sortable" data-col="3">Teléfono</th>
                        <th class="sortable" data-col="4">Membresía</th>
                        <th class="sortable" data-col="5">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td class="text-bold">#{{ $cliente->id_cliente }}</td>
                            <td class="text-bold">{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->correo ?? '—' }}</td>
                            <td>{{ $cliente->telefono ?? '—' }}</td>
                            <td><span class="badge badge-purple">{{ $cliente->tipo_membresia }}</span></td>
                            <td>
                                @if ($cliente->estado === 'activo')
                                    <span class="badge badge-green">activo</span>
                                @else
                                    <span class="badge badge-red">inactivo</span>
                                @endif
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                <p>No hay clientes registrados.</p>
            </div>
        </div>
    @endif
@endsection
