<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
        }

        h1 {
            font-size: 16px;
            margin-bottom: 4px;
        }

        .meta {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #1e293b;
            color: white;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }

        tr.bajo {
            background-color: #ffe5e5;
        }

        .badge-danger {
            color: #991b1b;
            font-weight: bold;
        }

        .badge-success {
            color: #166534;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Reporte de Inventario</h1>
    <p class="meta">
        Generado el {{ now()->format('d/m/Y H:i') }}
        @if ($soloStockBajo)
            — Solo productos con stock bajo
        @endif
        @if ($category)
            — Categoría: {{ $category }}
        @endif
        — {{ $products->count() }} producto(s)
    </p>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Stock Mín.</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr @if ($product->stock <= $product->min_stock) class="bajo" @endif>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->min_stock }}</td>
                    <td>
                        @if ($product->stock <= $product->min_stock)
                            <span class="badge-danger">Bajo stock</span>
                        @else
                            <span class="badge-success">Normal</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>