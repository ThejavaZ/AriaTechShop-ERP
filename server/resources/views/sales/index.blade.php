@extends('layout.main')

@section('title', 'Ventas')

@section('breadcrumb')
<<<<<<< HEAD

<li class="breadcrumb-item">
    <a href="{{ route('home') }}">Inicio</a>
</li>

<li class="breadcrumb-item active">
    Ventas
</li>
=======
<li class="breadcrumb-item">
    <a href="{{ route('home') }}">Inicio</a>
</li>
<li class="breadcrumb-item active">Ventas</li>
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
@endsection

@section('content')

<<<<<<< HEAD
<div class="card mb-4">


<div class="card-header">
    <i class="fas fa-dollar-sign me-1"></i>
    Ventas
</div>

<div class="card-body">

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

                <td>
                    {{ $sale->payment_method }}
                </td>

                <td>
                    {{ $sale->created_at->format('d/m/Y H:i:s') }}
                </td>

                <td>
                    {{ $sale->created_at->diffForHumans() }}
                </td>

                <td>
                    {{ $sale->updated_at->format('d/m/Y H:i:s') }}
                </td>

                <td>
                    {{ $sale->updated_at->diffForHumans() }}
                </td>

                <td class="d-flex gap-1">

                    <a href="{{ route('sales.show', $sale->id) }}"
                       class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a href="{{ route('sales.edit', $sale->id) }}"
                       class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit"></i>
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

@endsection
=======
{{-- <div>
    <a href="{{ route('sales.create') }}" class="btn btn-outline-primary">
        <i class="fas fa-plus"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-line me-1"></i>
        Ventas por fecha
    </div>

    <div class="card-body">

        <div style="width: 500px; height: 250px;">
            <canvas id="salesChart"></canvas>
        </div>

    </div>
</div> --}}

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-dollar-sign me-1"></i>
        Ventas
    </div>

    <div class="card-body">

        <table id="datatablesSimple">

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

            @foreach ($sales as $sale)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>${{ $sale->total_amount }}</td>
                    <td>{{ $sale->payment_method }}</td>

                    <td>{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $sale->created_at->diffForHumans() }}</td>

                    <td>{{ $sale->updated_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $sale->updated_at->diffForHumans() }}</td>

                    <td>

                        <a href="" class="btn btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="" class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="" class="btn btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- <script>

fetch("{{ route('sales.chart.data') }}")
.then(response => response.json())
.then(data => {

    const labels = data.map(item => item.date);
    const totals = data.map(item => item.total);

    const ctx = document.getElementById('salesChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ventas por fecha',
                data: totals,
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true
        }
    });

});

</script> --}}


@endsection
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
