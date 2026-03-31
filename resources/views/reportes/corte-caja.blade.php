@extends('layouts.dashboard')

@section('title', 'Corte de Caja - Gimnasio Pro')
@section('page-title', 'Corte de Caja')

@section('styles')
    @include('partials.table-styles')
    @include('partials.export-buttons')

    <style>
        /* ===== FILTER BAR CORTE ===== */
        .corte-filter-bar {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .corte-filter-bar .filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .corte-filter-bar .filter-group label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .corte-filter-bar .filter-input,
        .corte-filter-bar .filter-select {
            padding: 9px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: inherit;
            color: #111827;
            background: #fff;
            outline: none;
            transition: border-color 0.2s;
            min-width: 180px;
        }

        .corte-filter-bar .filter-input:focus,
        .corte-filter-bar .filter-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
        }

        .corte-btn-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .btn-apply {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: #1e3a5f;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-apply:hover {
            background: #15304f;
        }

        .btn-apply svg {
            width: 16px;
            height: 16px;
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn-print:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .btn-print svg {
            width: 16px;
            height: 16px;
        }

        .btn-clear {
            padding: 9px 18px;
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn-clear:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        /* ===== SUMMARY CARDS CORTE ===== */
        .corte-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .corte-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .corte-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .corte-card.highlight {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
            border-color: transparent;
        }

        .corte-card.highlight .corte-card-label,
        .corte-card.highlight .corte-card-value,
        .corte-card.highlight .corte-card-sub {
            color: #fff;
        }

        .corte-card.highlight .corte-card-label {
            opacity: 0.85;
        }

        .corte-card.highlight .corte-card-sub {
            opacity: 0.7;
        }

        .corte-card-icon {
            position: absolute;
            top: 16px;
            right: 18px;
            width: 24px;
            height: 24px;
            color: #9ca3af;
        }

        .corte-card.highlight .corte-card-icon {
            color: rgba(255,255,255,0.5);
        }

        .corte-card-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .corte-card-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 2px;
        }

        .corte-card-sub {
            font-size: 0.72rem;
            color: #9ca3af;
            font-weight: 500;
        }

        /* Membresías card value color */
        .corte-card.membresias .corte-card-value { color: #111827; }
        .corte-card.ventas-prod .corte-card-value { color: #ea580c; }

        /* Métodos combinados card */
        .metodos-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: 8px;
        }

        .metodo-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
        }

        .metodo-row .metodo-name {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            font-weight: 500;
        }

        .metodo-row .metodo-name .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .metodo-row .metodo-name .dot.cash { background: #ea580c; }
        .metodo-row .metodo-name .dot.card { background: #2563eb; }

        .metodo-row .metodo-amount {
            font-weight: 700;
            color: #111827;
        }

        /* ===== SECTION HEADERS ===== */
        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            margin-top: 8px;
        }

        .section-header svg {
            width: 20px;
            height: 20px;
            color: #6b7280;
        }

        .section-header h2 {
            font-size: 0.92rem;
            font-weight: 700;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* ===== TABLE CONTROLS (local for dual tables) ===== */
        .corte-table-controls-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .corte-table-show {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: #6b7280;
        }

        .corte-table-show select {
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.82rem;
            font-family: inherit;
            color: #111827;
            background: #fff;
            outline: none;
            cursor: pointer;
        }

        .corte-table-show select:focus { border-color: #6366f1; }

        .corte-table-search {
            position: relative;
        }

        .corte-table-search input {
            padding: 8px 14px 8px 34px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.82rem;
            font-family: inherit;
            color: #111827;
            background: #fff;
            outline: none;
            width: 240px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .corte-table-search input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
        }

        .corte-table-search svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #9ca3af;
            pointer-events: none;
        }

        .corte-table-controls-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .corte-table-info {
            font-size: 0.78rem;
            color: #6b7280;
        }

        .corte-table-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .corte-table-pagination button {
            padding: 6px 12px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            border-radius: 6px;
            font-size: 0.78rem;
            font-family: inherit;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
        }

        .corte-table-pagination button:hover:not(:disabled) {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .corte-table-pagination button:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .corte-table-pagination button.active {
            background: #111827;
            color: #fff;
            border-color: #111827;
        }

        /* Sortable headers */
        .data-table th.sortable {
            cursor: pointer;
            user-select: none;
            position: relative;
            padding-right: 24px;
        }

        .data-table th.sortable::after {
            content: '⇅';
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.65rem;
            color: #c0c4cc;
        }

        .data-table th.sortable.asc::after {
            content: '▲';
            color: #4f46e5;
        }

        .data-table th.sortable.desc::after {
            content: '▼';
            color: #4f46e5;
        }

        /* Badge for pago method */
        .badge-efectivo { background: #fff7ed; color: #ea580c; }
        .badge-tarjeta  { background: #eff6ff; color: #2563eb; }

        /* Ticket link style */
        .ticket-link {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.82rem;
        }

        .ticket-link:hover {
            text-decoration: underline;
        }

        .corte-section {
            margin-bottom: 32px;
        }

        @media (max-width: 1024px) {
            .corte-summary {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .corte-summary {
                grid-template-columns: 1fr;
            }

            .corte-table-search input {
                width: 160px;
            }

            .corte-filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .corte-btn-group {
                margin-left: 0;
                flex-wrap: wrap;
            }
        }

        @media print {
            .sidebar, .navbar, .corte-filter-bar, .corte-table-controls-top,
            .corte-table-controls-bottom, .hamburger, .sidebar-overlay { display: none !important; }
            .main-content { margin-left: 0 !important; margin-top: 0 !important; padding: 10px !important; }
            .corte-card { break-inside: avoid; }
            .corte-summary { grid-template-columns: repeat(4, 1fr); }
            body { background: #fff; }
            .data-table tr { page-break-inside: avoid; }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Corte de Caja</h1>
        <p>Resumen de ingresos por membresías y venta de productos.</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('reportes.corte-caja') }}" class="corte-filter-bar" id="corteForm">
        <div class="filter-group">
            <label for="fecha">Fecha del Corte</label>
            <input type="date" name="fecha" id="fecha" class="filter-input" value="{{ $fecha }}">
        </div>
        <div class="filter-group">
            <label for="forma_pago">Forma de Pago</label>
            <select name="forma_pago" id="forma_pago" class="filter-select">
                <option value="todos" {{ $formaPago === 'todos' ? 'selected' : '' }}>Todas</option>
                <option value="efectivo" {{ $formaPago === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="tarjeta" {{ $formaPago === 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
            </select>
        </div>
        <div class="corte-btn-group">
            <button type="submit" class="btn-apply">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
                Aplicar Filtros
            </button>
            <button type="button" class="btn-print" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m0 0a48.303 48.303 0 0 1 10.5 0m-10.5 0V5.625c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125v2.034" /></svg>
                Imprimir Reporte
            </button>
            <a href="{{ route('reportes.corte-caja') }}" class="btn-clear">Limpiar</a>
        </div>
    </form>

    {{-- Summary Cards --}}
    <div class="corte-summary">
        {{-- Ingreso Total Bruto --}}
        <div class="corte-card highlight">
            <svg class="corte-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
            <div class="corte-card-label">Ingreso Total Bruto</div>
            <div class="corte-card-value">${{ number_format($totalBruto, 2) }}</div>
            <div class="corte-card-sub">Suma de membresías y productos</div>
        </div>

        {{-- Membresías --}}
        <div class="corte-card membresias">
            <svg class="corte-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
            <div class="corte-card-label">Membresías</div>
            <div class="corte-card-value">${{ number_format($totalMembresias, 2) }}</div>
            <div class="corte-card-sub">Ingresos por pagos de clientes</div>
        </div>

        {{-- Venta Productos --}}
        <div class="corte-card ventas-prod">
            <svg class="corte-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
            <div class="corte-card-label">Venta Productos</div>
            <div class="corte-card-value">${{ number_format($totalVentasProductos, 2) }}</div>
            <div class="corte-card-sub">Ingresos por ventas de mostrador</div>
        </div>

        {{-- Métodos Combinados --}}
        <div class="corte-card">
            <svg class="corte-card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" /></svg>
            <div class="corte-card-label">Métodos Combinados</div>
            <div class="metodos-list">
                <div class="metodo-row">
                    <span class="metodo-name"><span class="dot cash"></span> Cash:</span>
                    <span class="metodo-amount">${{ number_format($totalEfectivo, 2) }}</span>
                </div>
                <div class="metodo-row">
                    <span class="metodo-name"><span class="dot card"></span> Card:</span>
                    <span class="metodo-amount">${{ number_format($totalTarjeta, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================== DETALLE DE MEMBRESÍAS ======================== --}}
    <div class="corte-section">
        <div class="section-header">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
            <h2>Detalle de Membresías</h2>
        </div>

        @if ($pagos->count() > 0)
            <div class="corte-table-controls-top">
                <div class="corte-table-show">
                    Mostrar
                    <select id="pagosPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                    registros
                </div>
                <div class="corte-table-search">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    <input type="text" id="pagosSearch" placeholder="Buscar...">
                </div>
            </div>

            <div class="table-wrapper">
                <table class="data-table" id="pagosTable">
                    <thead>
                        <tr>
                            <th class="sortable" data-col="0">Ticket</th>
                            <th class="sortable" data-col="1">Cliente</th>
                            <th class="sortable" data-col="2">Membresía</th>
                            <th class="sortable" data-col="3">Pago</th>
                            <th class="sortable text-right" data-col="4">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr>
                                <td><span class="ticket-link">#PA-{{ $pago->id_pago }}</span></td>
                                <td class="text-bold">{{ $pago->cliente->nombre ?? 'Público General' }}</td>
                                <td><span class="badge badge-blue">{{ ucfirst($pago->tipo_membresia) }}</span></td>
                                <td><span class="badge {{ $pago->forma_pago === 'efectivo' ? 'badge-efectivo' : 'badge-tarjeta' }}">{{ $pago->forma_pago }}</span></td>
                                <td class="text-right text-bold">${{ number_format($pago->monto, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="corte-table-controls-bottom">
                <div class="corte-table-info" id="pagosInfo"></div>
                <div class="corte-table-pagination" id="pagosPagination"></div>
            </div>
        @else
            <div class="table-wrapper">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                    <p>No hay membresías registradas en esta fecha.</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ======================== DETALLE DE VENTAS DE PRODUCTOS ======================== --}}
    <div class="corte-section">
        <div class="section-header">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
            <h2>Detalle de Ventas de Productos</h2>
        </div>

        @if ($ventas->count() > 0)
            <div class="corte-table-controls-top">
                <div class="corte-table-show">
                    Mostrar
                    <select id="ventasPerPage"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                    registros
                </div>
                <div class="corte-table-search">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    <input type="text" id="ventasSearch" placeholder="Buscar...">
                </div>
            </div>

            <div class="table-wrapper">
                <table class="data-table" id="ventasTable">
                    <thead>
                        <tr>
                            <th class="sortable" data-col="0">Venta</th>
                            <th class="sortable" data-col="1">Cliente</th>
                            <th class="sortable" data-col="2">Fecha/Hora</th>
                            <th class="sortable" data-col="3">Pago</th>
                            <th class="sortable text-right" data-col="4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td><span class="ticket-link">#VE-{{ $venta->id_venta }}</span></td>
                                <td class="text-bold">{{ $venta->cliente->nombre ?? 'Público General' }}</td>
                                <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('Y-m-d H:i:s') }}</td>
                                <td><span class="badge {{ $venta->forma_pago === 'efectivo' ? 'badge-efectivo' : 'badge-tarjeta' }}">{{ $venta->forma_pago }}</span></td>
                                <td class="text-right text-bold">${{ number_format($venta->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="corte-table-controls-bottom">
                <div class="corte-table-info" id="ventasInfo"></div>
                <div class="corte-table-pagination" id="ventasPagination"></div>
            </div>
        @else
            <div class="table-wrapper">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                    <p>No hay ventas de productos en esta fecha.</p>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
/**
 * Reusable table controller: search, pagination, sort
 */
function initTableController(config) {
    var table = document.getElementById(config.tableId);
    if (!table) return;

    var tbody = table.querySelector('tbody');
    if (!tbody) return;

    var allRows = Array.from(tbody.querySelectorAll('tr'));
    var filteredRows = allRows.slice();
    var perPage = 10;
    var currentPage = 1;
    var sortCol = -1;
    var sortDir = 'asc';

    var showSelect = document.getElementById(config.perPageId);
    var searchInput = document.getElementById(config.searchId);
    var infoEl = document.getElementById(config.infoId);
    var pagEl = document.getElementById(config.paginationId);

    function getCellValue(row, col) {
        var cell = row.querySelectorAll('td')[col];
        if (!cell) return '';
        return cell.textContent.trim();
    }

    function compareValues(a, b) {
        // Try numeric comparison
        var numA = parseFloat(a.replace(/[^0-9.\-]/g, ''));
        var numB = parseFloat(b.replace(/[^0-9.\-]/g, ''));
        if (!isNaN(numA) && !isNaN(numB)) {
            return numA - numB;
        }
        return a.localeCompare(b, 'es');
    }

    function sortRows() {
        if (sortCol < 0) return;
        filteredRows.sort(function(a, b) {
            var valA = getCellValue(a, sortCol);
            var valB = getCellValue(b, sortCol);
            var result = compareValues(valA, valB);
            return sortDir === 'asc' ? result : -result;
        });
    }

    function filterRows() {
        var q = (searchInput ? searchInput.value : '').toLowerCase().trim();
        if (!q) {
            filteredRows = allRows.slice();
        } else {
            filteredRows = allRows.filter(function(row) {
                return row.textContent.toLowerCase().indexOf(q) !== -1;
            });
        }
        sortRows();
        currentPage = 1;
        render();
    }

    function render() {
        var total = filteredRows.length;
        var totalPages = Math.ceil(total / perPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;

        var start = (currentPage - 1) * perPage;
        var end = Math.min(start + perPage, total);

        allRows.forEach(function(r) { r.style.display = 'none'; });
        for (var i = 0; i < filteredRows.length; i++) {
            tbody.appendChild(filteredRows[i]);
            filteredRows[i].style.display = (i >= start && i < end) ? '' : 'none';
        }

        if (infoEl) {
            if (total === 0) {
                infoEl.textContent = 'Sin resultados';
            } else {
                infoEl.textContent = 'Mostrando ' + (start + 1) + ' a ' + end + ' de ' + total + ' registros';
            }
        }

        if (pagEl) {
            var html = '';
            html += '<button ' + (currentPage <= 1 ? 'disabled' : '') + ' data-page="' + (currentPage - 1) + '">Anterior</button>';

            var maxBtns = 5;
            var startBtn = Math.max(1, currentPage - 2);
            var endBtn = Math.min(totalPages, startBtn + maxBtns - 1);
            if (endBtn - startBtn < maxBtns - 1) startBtn = Math.max(1, endBtn - maxBtns + 1);

            for (var p = startBtn; p <= endBtn; p++) {
                html += '<button class="' + (p === currentPage ? 'active' : '') + '" data-page="' + p + '">' + p + '</button>';
            }

            html += '<button ' + (currentPage >= totalPages ? 'disabled' : '') + ' data-page="' + (currentPage + 1) + '">Siguiente</button>';
            pagEl.innerHTML = html;
        }
    }

    // Events
    if (showSelect) {
        showSelect.addEventListener('change', function() {
            perPage = parseInt(this.value);
            currentPage = 1;
            render();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
    }

    if (pagEl) {
        pagEl.addEventListener('click', function(e) {
            var btn = e.target.closest('button');
            if (btn && !btn.disabled && btn.dataset.page) {
                currentPage = parseInt(btn.dataset.page);
                render();
            }
        });
    }

    // Sortable headers
    var headers = table.querySelectorAll('th.sortable');
    headers.forEach(function(th) {
        th.addEventListener('click', function() {
            var col = parseInt(th.dataset.col);
            // Reset other headers
            headers.forEach(function(h) {
                if (h !== th) {
                    h.classList.remove('asc', 'desc');
                }
            });

            if (sortCol === col) {
                sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                sortCol = col;
                sortDir = 'asc';
            }

            th.classList.remove('asc', 'desc');
            th.classList.add(sortDir);

            filterRows();
        });
    });

    render();
}

document.addEventListener('DOMContentLoaded', function() {
    // Init Pagos table
    initTableController({
        tableId: 'pagosTable',
        perPageId: 'pagosPerPage',
        searchId: 'pagosSearch',
        infoId: 'pagosInfo',
        paginationId: 'pagosPagination'
    });

    // Init Ventas table
    initTableController({
        tableId: 'ventasTable',
        perPageId: 'ventasPerPage',
        searchId: 'ventasSearch',
        infoId: 'ventasInfo',
        paginationId: 'ventasPagination'
    });
});
</script>
@endsection
