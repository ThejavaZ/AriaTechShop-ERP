@extends('layout.main')

@section('content')

<div class="container">
    <h2>Registrar Producto</h2>

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
            <label>Descripción (Opcional)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Registrar Producto
        </button>
    </form>
</div>

@endsection