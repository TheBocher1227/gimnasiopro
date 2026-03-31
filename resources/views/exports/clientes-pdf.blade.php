<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clientes</title>
    @include('exports.pdf-styles')
</head>
<body>
    <div class="report-header">
        <h1>Directorio de Clientes</h1>
        <p>Gimnasio Pro &bull; {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Membresía</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $c)
                <tr>
                    <td>#{{ $c->id_cliente }}</td>
                    <td class="text-bold">{{ $c->nombre }}</td>
                    <td>{{ $c->correo ?? '—' }}</td>
                    <td>{{ $c->telefono ?? '—' }}</td>
                    <td>{{ $c->tipo_membresia }}</td>
                    <td>{{ $c->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">{{ $clientes->count() }} clientes</div>
    <div class="footer">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
</body>
</html>
