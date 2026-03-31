{{-- Estilos para botones de exportación --}}
<style>
    .export-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.15s;
        background: #fff;
        color: #374151;
    }

    .btn-export:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .btn-export svg {
        width: 16px;
        height: 16px;
    }

    .btn-export.pdf {
        color: #dc2626;
        border-color: #fecaca;
    }

    .btn-export.pdf:hover {
        background: #fef2f2;
        border-color: #dc2626;
    }

    .btn-export.excel {
        color: #16a34a;
        border-color: #bbf7d0;
    }

    .btn-export.excel:hover {
        background: #f0fdf4;
        border-color: #16a34a;
    }
</style>
