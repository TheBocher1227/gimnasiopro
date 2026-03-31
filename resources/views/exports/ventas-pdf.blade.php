<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
    @include('exports.pdf-styles')
</head>
<body>
    <div class="report-header">
        <h1>Reporte de Ventas</h1>
        <p>Período: {{ $fechaInicio }} al {{ $fechaFin }} &bull; Gimnasio Pro</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Forma Pago</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $v)
                <tr>
                    <td>#{{ $v->id_venta }}</td>
                    <td>{{ $v->cliente->nombre ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($v->fecha_venta)->format('d/m/Y H:i') }}</td>
                    <td>{{ $v->forma_pago }}</td>
                    <td class="text-right">${{ number_format($v->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">Total: ${{ number_format($total, 2) }} &bull; {{ $ventas->count() }} ventas</div>
    <div class="footer">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
</body>
</html>
