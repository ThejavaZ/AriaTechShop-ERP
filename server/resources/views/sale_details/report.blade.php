@extends('layout.main')

@section('title','Reporte Detalle Ventas')

@section('content')

<h3>Reporte Detalle Ventas</h3>


<a href="{{ route('sale_details.report.excel') }}" class="btn btn-success mb-3">
    Exportar Excel
</a>

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>Producto</th>
<th>Cantidad</th>
<th>Total</th>
</tr>
</thead>

<tbody>

@foreach($details as $detail)

<tr>
<td>{{ $detail->id }}</td>
<td>{{ $detail->product_name }}</td>
<td>{{ $detail->quantity }}</td>
<td>${{ $detail->total_price }}</td>
</tr>

@endforeach

</tbody>

</table>

@endsection