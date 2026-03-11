@extends('layout.main')

@section('title', 'Inventario')

@section('breadcrumb')
    <li class="breadcrumb-item active">Inventario</li>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-boxes me-1"></i> Lista de Productos</span>
        <div>
            <a href="{{ route('inventory.restock') }}" class="btn btn-success btn-sm me-1">
                <i class="fas fa-plus"></i> Restock
            </a>
            <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input
                        type="text"
                        id="search-input"
                        class="form-control"
                        placeholder="Buscar por nombre…"
                        value="{{ $search }}"
                        autocomplete="off"
                    >
                </div>
            </div>

            <div class="col-12 col-md-3">
                <select id="category-select" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-2">
                <select id="sort-select" class="form-select">
                    <option value="name"     {{ $sort === 'name'     ? 'selected' : '' }}>Nombre</option>
                    <option value="category" {{ $sort === 'category' ? 'selected' : '' }}>Categoría</option>
                    <option value="price"    {{ $sort === 'price'    ? 'selected' : '' }}>Precio</option>
                    <option value="stock"    {{ $sort === 'stock'    ? 'selected' : '' }}>Stock</option>
                </select>
            </div>

            <div class="col-12 col-md-2">
                <select id="order-select" class="form-select">
                    <option value="asc"  {{ $order === 'asc'  ? 'selected' : '' }}>↑ Ascendente</option>
                    <option value="desc" {{ $order === 'desc' ? 'selected' : '' }}>↓ Descendente</option>
                </select>
            </div>
        </div>

        @if($products->isEmpty())
            <p class="text-center text-muted">No hay productos registrados aún.</p>
        @else

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)

                <tr @if($product->tieneStockBajo()) style="background-color:#ffe5e5;" @endif>

                    <td>{{ $product->name }}</td>

                    <td>{{ $product->category }}</td>

                    <td>${{ number_format($product->price, 2) }}</td>

                    <td>{{ $product->stock }}</td>

                    <td>
                        @if($product->tieneStockBajo())
                            <span class="badge bg-danger">Bajo stock</span>
                        @else
                            <span class="badge bg-success">Normal</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('inventory.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                    </td>

                </tr>

                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}

        @endif

    </div>
</div>

<script>
(function () {
    const DEBOUNCE_MS = 400;
    let debounceTimer;

    const searchInput   = document.getElementById('search-input');
    const categorySelect = document.getElementById('category-select');
    const sortSelect    = document.getElementById('sort-select');
    const orderSelect   = document.getElementById('order-select');

    function buildUrl() {
        const params = new URLSearchParams();
        const search   = searchInput.value.trim();
        const category = categorySelect.value;
        const sort     = sortSelect.value;
        const order    = orderSelect.value;

        if (search)   params.set('search',   search);
        if (category) params.set('category', category);
        if (sort)     params.set('sort',     sort);
        if (order)    params.set('order',    order);

        return '{{ route('inventory.index') }}?' + params.toString();
    }

    function navigate() {
        window.location.href = buildUrl();
    }

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(navigate, DEBOUNCE_MS);
    });

    categorySelect.addEventListener('change', navigate);
    sortSelect.addEventListener('change', navigate);
    orderSelect.addEventListener('change', navigate);
})();
</script>
@endsection