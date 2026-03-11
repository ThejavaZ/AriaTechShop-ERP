@extends('layout.main')

@section('title', 'Registrar Producto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Registrar Producto</li>
@endsection

@section('content')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-box me-1"></i> Registrar Producto
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Categoría</label>
                <input type="text" name="category" class="form-control">
                @error('category') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Precio</label>
                <input type="number" step="0.01" name="price" class="form-control">
                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Cantidad Disponible</label>
                <input type="number" name="stock" class="form-control">
                @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Stock Mínimo</label>
                <input type="number" name="min_stock" class="form-control" value="5">
                @error('min_stock') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Descripción (Opcional)</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Registrar Producto
            </button>

            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>
</div>

@endsection