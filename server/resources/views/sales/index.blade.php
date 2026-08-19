@extends('layout.main')

@section('title', 'Ventas')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}">Inicio</a>
</li>
<li class="breadcrumb-item active">Ventas</li>
@endsection

@section('content')

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
