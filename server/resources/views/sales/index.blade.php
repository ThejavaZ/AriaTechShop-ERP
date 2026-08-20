@extends('layout.main')

@section('title', 'Ventas')

@section('breadcrumb')

<li class="breadcrumb-item">
    <a href="{{ route('home') }}">Inicio</a>
</li>

<li class="breadcrumb-item active">
    Ventas
</li>

@endsection

@section('content')

<div class="card mb-4">

    <div class="card-header">
        <i class="fas fa-dollar-sign me-1"></i>
        Ventas
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>
            </div>
        @endif

        <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i>
            Registrar venta
        </a>

        <a href="{{ route('sales.report') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-file"></i>
            Reporte
        </a>

        <table id="datatablesSimple" class="table table-striped">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Factura</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Método de pago</th>
                    <th>Creado</th>
                    <th>Actualizado</th>
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

                        <td>
                            {{ $sale->payment_method }}
                        </td>

                        <td>
                            {{ $sale->created_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td>
                            {{ $sale->updated_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td>

                            <div class="d-flex gap-1">

                                <a
                                    href="{{ route('sales.show', ['sale' => $sale->id]) }}"
                                    class="btn btn-outline-info btn-sm"
                                    title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('sales.edit', ['sale' => $sale->id]) }}"
                                    class="btn btn-outline-warning btn-sm"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form
                                    action="{{ route('sales.destroy', ['sale' => $sale->id]) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        title="Eliminar"
                                        onclick="return confirm('¿Desea eliminar esta venta?')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No hay ventas registradas
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
