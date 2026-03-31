<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Inventario</title>
    @include('exports.pdf-styles')
</head>
<body>
    <div class="report-header">
        <h1>Historial de Inventario</h1>
        <p>Período: {{ $fechaInicio }} al {{ $fechaFin }} &bull; Gimnasio Pro</p>
    </div>

    <table>
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
            @foreach ($historial as $m)
                <tr>
                    <td>#{{ $m->id_historial }}</td>
                    <td>{{ $m->producto->nombre ?? '—' }}</td>
                    <td>{{ $m->tipo }}</td>
                    <td>{{ $m->cantidad }}</td>
                    <td>{{ $m->motivo }}</td>
                    <td>{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y H:i') }}</td>
                    <td class="text-right">{{ $m->stock_anterior }} → {{ $m->stock_nuevo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">{{ $historial->count() }} movimientos</div>
    <div class="footer">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
</body>
</html>
