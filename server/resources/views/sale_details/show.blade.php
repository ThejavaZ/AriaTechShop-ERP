@extends('layout.main')

@section('title','Ver Detalle')

@section('content')

<h3>Detalle de Venta</h3>

<div class="card">
<div class="card-body">

<p><strong>ID:</strong> {{ $detail->id }}</p>

<p><strong>Producto:</strong>
{{ $detail->product_name }}
</p>

<p><strong>Cantidad:</strong>
{{ $detail->quantity }}
</p>

<p><strong>Total:</strong>
${{ number_format($detail->total_price,2) }}
</p>

</div>
</div>

@endsection