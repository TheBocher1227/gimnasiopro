{{-- Estilos reutilizables para tablas y filtros de reportes --}}
<style>
    /* Filtro de fechas */
    .filter-bar {
        display: flex;
        align-items: flex-end;
        gap: 14px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .filter-group label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .filter-input {
        padding: 9px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: inherit;
        color: #111827;
        background: #fff;
        outline: none;
        transition: border-color 0.2s;
    }

    .filter-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .btn-filter {
        padding: 9px 20px;
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-filter:hover {
        background: #1f2937;
    }

    /* Header de página */
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .page-header p {
        font-size: 0.85rem;
        color: #6b7280;
    }

    /* Summary cards */
    .summary-row {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px 22px;
        min-width: 180px;
    }

    .summary-card .label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 4px;
    }

    .summary-card .value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #111827;
    }

    /* Tabla */
    .table-wrapper {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-table th {
        padding: 12px 16px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .data-table td {
        padding: 14px 16px;
        font-size: 0.84rem;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover {
        background: #fafafa;
    }

    .data-table .text-bold {
        font-weight: 600;
        color: #111827;
    }

    .data-table .text-muted {
        color: #9ca3af;
        font-size: 0.78rem;
    }

    .data-table .text-right {
        text-align: right;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-green  { background: #f0fdf4; color: #16a34a; }
    .badge-red    { background: #fef2f2; color: #dc2626; }
    .badge-blue   { background: #eff6ff; color: #2563eb; }
    .badge-orange { background: #fff7ed; color: #ea580c; }
    .badge-gray   { background: #f3f4f6; color: #6b7280; }
    .badge-purple { background: #faf5ff; color: #9333ea; }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #9ca3af;
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        margin-bottom: 12px;
        color: #d1d5db;
    }

    .empty-state p {
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            min-width: 600px;
        }
    }
</style>
