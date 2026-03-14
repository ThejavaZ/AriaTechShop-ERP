@extends('layout.main')

@section('title', 'Editar Precio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Editar Precio</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tag me-1"></i> Editar Precio — {{ $product->name }}
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('inventory.updatePrice', $product->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label>Producto</label>
                    <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Precio Actual</label>
                    <input type="text" class="form-control" value="${{ number_format($product->price, 2) }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Nuevo Precio</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-warning">Actualizar Precio</button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection