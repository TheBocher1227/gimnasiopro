<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Pagos</title>
    @include('exports.pdf-styles')
</head>
<body>
    <div class="report-header">
        <h1>Reporte de Pagos</h1>
        <p>Período: {{ $fechaInicio }} al {{ $fechaFin }} &bull; Gimnasio Pro</p>
    </div>

    <table>
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
            @foreach ($pagos as $p)
                <tr>
                    <td>#{{ $p->id_pago }}</td>
                    <td>{{ $p->cliente->nombre ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y') }}</td>
                    <td>{{ $p->tipo_membresia }}</td>
                    <td>{{ $p->forma_pago }}</td>
                    <td class="text-right">${{ number_format($p->monto, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">Total: ${{ number_format($total, 2) }} &bull; {{ $pagos->count() }} pagos</div>
    <div class="footer">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
</body>
</html>
