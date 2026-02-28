@extends('layout.main')

@section('title', 'Restock de Mercancía')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Restock</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-boxes me-1"></i> Registrar Restock de Mercancía
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('inventory.storeRestock') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Producto</label>
                    <select name="inventory_id" class="form-control">
                        <option value="">-- Selecciona un producto --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Stock actual: {{ $product->stock }})</option>
                        @endforeach
                    </select>
                    @error('inventory_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label>Cantidad a Ingresar</label>
                    <input type="number" name="cantidad" min="1" class="form-control">
                    @error('cantidad') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-success">Registrar Restock</button>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection