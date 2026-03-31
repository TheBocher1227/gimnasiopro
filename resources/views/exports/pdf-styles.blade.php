{{-- Estilos base para PDFs de exportación --}}
<style>
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 11px;
        color: #333;
        margin: 0;
        padding: 20px;
    }
    .report-header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #111827;
        padding-bottom: 10px;
    }
    .report-header h1 {
        font-size: 18px;
        margin: 0 0 4px;
        color: #111827;
    }
    .report-header p {
        font-size: 11px;
        color: #666;
        margin: 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th {
        background: #111827;
        color: #fff;
        padding: 8px 10px;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
    }
    td {
        padding: 7px 10px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 11px;
    }
    tr:nth-child(even) td {
        background: #f9fafb;
    }
    .text-right { text-align: right; }
    .text-bold { font-weight: 600; }
    .badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 9px;
        font-weight: 600;
    }
    .badge-green { background: #f0fdf4; color: #16a34a; }
    .badge-red { background: #fef2f2; color: #dc2626; }
    .badge-blue { background: #eff6ff; color: #2563eb; }
    .badge-purple { background: #faf5ff; color: #9333ea; }
    .badge-orange { background: #fff7ed; color: #ea580c; }
    .summary {
        margin-top: 15px;
        text-align: right;
        font-size: 12px;
        font-weight: 600;
    }
    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 9px;
        color: #999;
    }
</style>
