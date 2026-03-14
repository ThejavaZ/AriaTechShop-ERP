@extends('layout.main')

@section('title', 'Ajustar Stock')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Ajustar Stock</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-sliders-h me-1"></i> Ajustar Stock — {{ $product->name }}
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('inventory.storeAdjustStock', $product->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label>Producto</label>
                    <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Stock Actual</label>
                    <input type="text" class="form-control" value="{{ $product->stock }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Nuevo Stock</label>
                    <input type="number" name="stock" min="0" class="form-control" required>
                    @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-info">Ajustar Stock</button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection