@extends('layout.main')

@section('title', 'Ventas')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}">Inicio</a>
</li>
<li class="breadcrumb-item active">Ventas</li>
@endsection

@section('content')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-dollar-sign me-1"></i>
        Ventas
    </div>

    <div class="card-body">

        <table id="datatablesSimple" class="table table-striped">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Método de pago</th>
                    <th>Creado</th>
                    <th>Creado Hace</th>
                    <th>Actualizado</th>
                    <th>Actualizado Hace</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($sales as $sale)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer_name }}</td>

                    <td>
                        ${{ number_format($sale->total_amount, 2) }}
                    </td>

                    <td>{{ $sale->payment_method }}</td>

                    <td>{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $sale->created_at->diffForHumans() }}</td>

                    <td>{{ $sale->updated_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $sale->updated_at->diffForHumans() }}</td>

                    <td class="d-flex gap-1">

                        <a href="" class="btn btn-outline-info btn-sm" title="Ver venta">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="" class="btn btn-outline-warning btn-sm" title="Editar venta">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="" class="btn btn-outline-danger btn-sm" title="Eliminar venta">
                            <i class="fas fa-trash"></i>
                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="10" class="text-center text-muted">
                        No hay ventas registradas
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection