@extends('layout.main')

@section('title','Editar Detalle')

@section('content')

<h3>Editar Detalle de Venta</h3>

<form action="{{ route('sale_details.update',$detail->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Producto</label>
<input type="text" name="product_name"
class="form-control"
value="{{ $detail->product_name }}">
</div>

<div class="mb-3">
<label>Cantidad</label>
<input type="number"
name="quantity"
class="form-control"
value="{{ $detail->quantity }}">
</div>

<div class="mb-3">
<label>Total</label>
<input type="number"
name="total_price"
class="form-control"
value="{{ $detail->total_price }}">
</div>

<button class="btn btn-primary">Actualizar</button>

</form>

@endsection