@extends('layout.main')

@section('title', 'Reporte de Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Reporte</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-alt me-1"></i> Reporte de Inventario</span>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">

            {{-- Filtros --}}
            <form method="GET" action="{{ route('inventory.report') }}" class="row g-2 mb-4">
                <div class="col-12 col-md-4">
                    <select name="category" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>
                                {{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="stock_bajo" id="stock_bajo" value="1"
                            {{ $soloStockBajo ? 'checked' : '' }}>
                        <label class="form-check-label" for="stock_bajo">
                            Solo productos con stock bajo
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>

            {{-- Botones de exportación --}}
            <div class="d-flex gap-2 mb-3">
                <a href="{{ route('inventory.report.pdf', ['category' => $category, 'stock_bajo' => $soloStockBajo ? 1 : 0]) }}"
                    class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </a>
                <a href="{{ route('inventory.report.excel', ['category' => $category, 'stock_bajo' => $soloStockBajo ? 1 : 0]) }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </a>
                <a href="{{ route('inventory.report.word', ['category' => $category, 'stock_bajo' => $soloStockBajo ? 1 : 0]) }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-file-word"></i> Exportar Word
                </a>
            </div>

            <p class="text-muted small mb-2">
                Generado el {{ now()->format('d/m/Y H:i') }} —
                {{ $products->count() }} producto(s) encontrado(s)
                @if ($soloStockBajo)
                    <span class="badge bg-danger ms-1">Solo stock bajo</span>
                @endif
                @if ($category)
                    <span class="badge bg-secondary ms-1">{{ $category }}</span>
                @endif
            </p>

            {{-- Tabla --}}
            @if ($products->isEmpty())
                <p class="text-center text-muted">No se encontraron productos con los filtros seleccionados.</p>
            @else
                <table class="table table-bordered table-striped">
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
                            <tr @if ($product->tieneStockBajo()) style="background-color:#ffe5e5;" @endif>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->min_stock }}</td>
                                <td>
                                    @if ($product->tieneStockBajo())
                                        <span class="badge bg-danger">Bajo stock</span>
                                    @else
                                        <span class="badge bg-success">Normal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
@endsection