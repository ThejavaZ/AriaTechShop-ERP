@extends('layout.main')

@section('title','Ver Venta')

@section('content')

<h3>Detalle de Venta</h3>

<div class="card mb-3">
<div class="card-body">

<p><strong>Factura:</strong> {{ $sale->invoice_number }}</p>
<p><strong>Cliente:</strong> {{ $sale->customer_name }}</p>
<p><strong>Email:</strong> {{ $sale->customer_email }}</p>
<p><strong>Total:</strong> ${{ number_format($sale->total_amount,2) }}</p>

</div>
</div>

<h4>Productos</h4>

<table class="table table-striped">

<thead>
<tr>
<th>Producto</th>
<th>Precio</th>
<th>Cantidad</th>
<th>Total</th>
</tr>
</thead>

<tbody>

@foreach($sale->details as $detail)

<tr>
<td>{{ $detail->product_name }}</td>
<td>${{ number_format($detail->unit_price,2) }}</td>
<td>{{ $detail->quantity }}</td>
<td>${{ number_format($detail->total_price,2) }}</td>
</tr>

@endforeach

</tbody>

</table>

@endsection