@extends('layout.main')

@section('title', 'Editar Producto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Editar Producto</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tag me-1"></i> Editar Producto — {{ $product->name }}
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('inventory.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                </div>

                <div class="mb-3">
                    <label>Categoría</label>
                    <input type="text" name="category" class="form-control" value="{{ $product->category }}">
                </div>

                <div class="mb-3">
                    <label>Precio</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}">
                </div>

                <div class="mb-3">
                    <label>Stock Actual</label>
                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                </div>

                <div class="mb-3">
                    <label>Stock Mínimo</label>
                    <input type="number" name="min_stock" class="form-control" value="{{ $product->min_stock }}">
                </div>

                <div class="mb-3">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning">Actualizar Producto</button>

                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
