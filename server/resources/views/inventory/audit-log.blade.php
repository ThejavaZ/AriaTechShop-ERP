@extends('layout.main')

@section('title', 'Bitácora de Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventario</a></li>
    <li class="breadcrumb-item active">Bitácora</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-history me-1"></i> Bitácora de Inventario</span>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('inventory.audit-log') }}" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Desde</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Orden</label>
                    <select name="order" class="form-select">
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Más reciente</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Más antiguo</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-1">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('inventory.audit-log') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>

            @if($logs->isEmpty())
                <p class="text-center text-muted">No hay registros en la bitácora.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->user->name ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $log->action }}</span>
                                </td>
                                <td>{{ $log->product->name ?? '—' }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $logs->links() }}
            @endif
        </div>
    </div>
@endsection