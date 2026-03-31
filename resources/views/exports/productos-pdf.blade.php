<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Productos</title>
    @include('exports.pdf-styles')
</head>
<body>
    <div class="report-header">
        <h1>Inventario de Productos</h1>
        <p>Gimnasio Pro &bull; {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $p)
                <tr>
                    <td>#{{ $p->id_producto }}</td>
                    <td>{{ $p->codigo_barras }}</td>
                    <td class="text-bold">{{ $p->nombre }}</td>
                    <td>{{ $p->descripcion }}</td>
                    <td class="text-right">${{ number_format($p->precio, 2) }}</td>
                    <td class="text-right">{{ $p->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">{{ $productos->count() }} productos</div>
    <div class="footer">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
</body>
</html>
