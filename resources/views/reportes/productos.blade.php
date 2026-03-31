@extends('layouts.dashboard')

@section('title', 'Productos - Gimnasio Pro')
@section('page-title', 'Productos e Inventario')

@section('styles')
    @include('partials.table-styles')
    @include('partials.table-controls')
    @include('partials.export-buttons')
@endsection

@section('content')
    <div class="page-header">
        <h1>Inventario de Productos</h1>
        <p>Administra los productos disponibles para la venta.</p>
    </div>

    {{-- Resumen --}}
    <div class="summary-row">
        <div class="summary-card">
            <div class="label">Total Productos</div>
            <div class="value">{{ $productos->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Stock Bajo (≤5)</div>
            <div class="value">{{ $productos->where('stock', '<=', 5)->count() }}</div>
        </div>
    </div>

    {{-- Tabla --}}
    @if ($productos->count() > 0)
        <div class="table-controls-top">
            <div class="table-show">
                Mostrar
                <select id="tcPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                registros
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="export-buttons">
                    <a href="{{ route('exportar.productos.pdf') }}" class="btn-export pdf"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg> PDF</a>
                    <a href="{{ route('exportar.productos.excel') }}" class="btn-export excel"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125" /></svg> Excel</a>
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
                        <th class="sortable" data-col="1">Código</th>
                        <th class="sortable" data-col="2">Nombre</th>
                        <th class="sortable" data-col="3">Descripción</th>
                        <th class="sortable" data-col="4">Precio</th>
                        <th class="sortable" data-col="5">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td class="text-bold">#{{ $producto->id_producto }}</td>
                            <td class="text-muted">{{ $producto->codigo_barras }}</td>
                            <td class="text-bold">{{ $producto->nombre }}</td>
                            <td class="text-muted">{{ $producto->descripcion }}</td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>
                                @if ($producto->stock <= 1)
                                    <span class="badge badge-red">{{ $producto->stock }} unidades</span>
                                @elseif ($producto->stock <= 10)
                                    <span class="badge badge-orange">{{ $producto->stock }} unidades</span>
                                @else
                                    <span class="badge badge-green">{{ $producto->stock }} unidades</span>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                <p>No hay productos registrados.</p>
            </div>
        </div>
    @endif
@endsection
