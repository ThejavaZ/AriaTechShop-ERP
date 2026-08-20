@extends('layout.main')

@section('title','Reporte de Ventas')

@section('content')

<h3>Reporte de Ventas</h3>


<a href="{{ route('sales.report.excel') }}" class="btn btn-success mb-3">
    Exportar Excel
</a>


<table class="table table-striped">

<thead>
<tr>
<th>Factura</th>
<th>Cliente</th>
<th>Total</th>
<th>Fecha</th>
</tr>
</thead>

<tbody>

@foreach($sales as $sale)

<tr>
<td>{{ $sale->invoice_number }}</td>
<td>{{ $sale->customer_name }}</td>
<td>${{ $sale->total_amount }}</td>
<td>{{ $sale->sale_date }}</td>
</tr>

@endforeach

</tbody>

</table>

@endsection