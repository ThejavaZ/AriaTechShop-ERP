@extends('layout.main')

@section('title', 'Movimientos de Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Movimientos</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-exchange-alt me-1"></i> Historial de Movimientos</span>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('inventory.movements') }}" class="row g-3 mb-4">
                <div class="col-md-2">
                    <label class="form-label">Tipo</label>
                    <select name="type" class="form-select">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('type') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="ajuste" {{ request('type') == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                        <option value="salida" {{ request('type') == 'salida' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Desde</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Orden</label>
                    <select name="order" class="form-select">
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Más reciente</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Más antiguo</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-1">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('inventory.movements') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>

            @if($movements->isEmpty())
                <p class="text-center text-muted">No hay movimientos registrados.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Referencia</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movements as $mov)
                            <tr>
                                <td>{{ $mov->product->name ?? '—' }}</td>
                                <td>
                                    @php
                                        $badge = match($mov->type) {
                                            'entrada' => 'bg-success',
                                            'salida' => 'bg-danger',
                                            'ajuste' => 'bg-warning text-dark',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $mov->type }}</span>
                                </td>
                                <td>{{ $mov->quantity }}</td>
                                <td>{{ $mov->reference ?? '—' }}</td>
                                <td>{{ $mov->user->name ?? '—' }}</td>
                                <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $movements->links() }}
            @endif
        </div>
    </div>
@endsection