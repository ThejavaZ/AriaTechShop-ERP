@extends('layout.main')

@section('title', 'Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item active">Inventario</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-boxes me-1"></i> Lista de Productos</span>
            <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
        </div>
        <div class="card-body">
            @if($products->isEmpty())
                <p class="text-center text-muted">No hay productos registrados aún.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            @endif
        </div>
    </div>
@endsection