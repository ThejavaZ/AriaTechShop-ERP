@extends('layout.main')

@section('title', 'Detalles de venta')

@section('breadcrumb')

<li class="breadcrumb-item">
    <a href="{{ route('home') }}">Inicio</a>
</li>

<li class="breadcrumb-item active">
    Detalle de venta
</li>
@endsection

@section('content')

<div class="card mb-4">

<div class="card-header">
    <i class="fas fa-dollar-sign me-1"></i>
    Detalle Venta
</div>

<div class="card-body">

    <a href="{{ route('sales.report') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-file"></i>
        Reporte
    </a>

<div class="card-body">

<table id="datatablesSimple" class="table table-striped">

<thead>
<tr>
<th>No.</th>
<th>Venta ID</th>
<th>Producto</th>
<th>Precio Unitario</th>
<th>Cantidad</th>
<th>Total</th>
<th>Creado</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse ($details as $detail)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $detail->sale_id }}</td>
<td>{{ $detail->product_name }}</td>

<td>
${{ number_format($detail->unit_price,2) }}
</td>

<td>{{ $detail->quantity }}</td>

<td>
${{ number_format($detail->total_price,2) }}
</td>

<td>{{ $detail->created_at->format('d/m/Y H:i:s') }}</td>

<td class="d-flex gap-1">

<a href="{{ route('sale_details.show',$detail->id) }}" class="btn btn-outline-info btn-sm">
<i class="fas fa-eye"></i>
</a>

<a href="{{ route('sale_details.edit',$detail->id) }}" class="btn btn-outline-warning btn-sm">
<i class="fas fa-edit"></i>
</a>

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center text-muted">
No hay detalles de venta
</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection