@extends('layout.main')

@section('title','Editar Venta')

@section('content')

<h3>Editar Venta</h3>

<form action="{{ route('sales.update', $sale->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label>Cliente</label>
        <input type="text" name="customer_name"
               class="form-control"
               value="{{ $sale->customer_name }}">
    </div>

    <div class="mb-3">
        <label>Teléfono</label>
        <input type="text" name="customer_phone"
               class="form-control"
               value="{{ $sale->customer_phone }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="text" name="customer_email"
               class="form-control"
               value="{{ $sale->customer_email }}">
    </div>

    <div class="mb-3">
        <label>Total</label>
        <input type="number" step="0.01"
               name="total_amount"
               class="form-control"
               value="{{ $sale->total_amount }}">
    </div>

    <button class="btn btn-primary">
        Actualizar
    </button>
</form>

@endsection