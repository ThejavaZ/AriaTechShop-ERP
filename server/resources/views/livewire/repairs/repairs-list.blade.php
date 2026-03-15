<div class="p-6">
    <!-- Mensajes de éxito/error -->
    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reparaciones</h1>
            <p class="mt-1 text-sm text-gray-500">Gestiona todas las reparaciones del sistema</p>
        </div>
        <button wire:click="openCreateModal"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Reparación
        </button>
    </div>

    <!-- Filtros por estado (Tabs) -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto">
            <button wire:click="$set('statusFilter', '')"
                    class="@if($statusFilter === '') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Todas
                <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium @if($statusFilter === '') bg-indigo-100 text-indigo-600 @else bg-gray-100 text-gray-900 @endif">
                    {{ $statusCounts['all'] }}
                </span>
            </button>

            <button wire:click="$set('statusFilter', 'pending')"
                    class="@if($statusFilter === 'pending') border-yellow-500 text-yellow-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Pendientes
                <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium @if($statusFilter === 'pending') bg-yellow-100 text-yellow-600 @else bg-gray-100 text-gray-900 @endif">
                    {{ $statusCounts['pending'] }}
                </span>
            </button>

            <button wire:click="$set('statusFilter', 'diagnosed')"
                    class="@if($statusFilter === 'diagnosed') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Diagnosticadas
                <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium @if($statusFilter === 'diagnosed') bg-blue-100 text-blue-600 @else bg-gray-100 text-gray-900 @endif">
                    {{ $statusCounts['diagnosed'] }}
                </span>
            </button>

            <button wire:click="$set('statusFilter', 'in_progress')"
                    class="@if($statusFilter === 'in_progress') border-orange-500 text-orange-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                En Progreso
                <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium @if($statusFilter === 'in_progress') bg-orange-100 text-orange-600 @else bg-gray-100 text-gray-900 @endif">
                    {{ $statusCounts['in_progress'] }}
                </span>
            </button>

            <button wire:click="$set('statusFilter', 'completed')"
                    class="@if($statusFilter === 'completed') border-green-500 text-green-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Completadas
                <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium @if($statusFilter === 'completed') bg-green-100 text-green-600 @else bg-gray-100 text-gray-900 @endif">
                    {{ $statusCounts['completed'] }}
                </span>
            </button>

            <button wire:click="$set('statusFilter', 'delivered')"
                    class="@if($statusFilter === 'delivered') border-gray-500 text-gray-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Entregadas
                <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium @if($statusFilter === 'delivered') bg-gray-100 text-gray-600 @else bg-gray-100 text-gray-900 @endif">
                    {{ $statusCounts['delivered'] }}
                </span>
            </button>
        </nav>
    </div>

    <!-- Barra de búsqueda -->
    <div class="mb-6 flex items-center justify-between gap-4">
        <div class="flex-1 max-w-lg">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search"
                       type="text"
                       placeholder="Buscar por número, cliente, dispositivo..."
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        @if($search || $statusFilter)
            <button wire:click="clearFilters"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Limpiar filtros
            </button>
        @endif
    </div>

    <!-- Tabla de reparaciones -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th wire:click="sortBy('repair_number')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <div class="flex items-center space-x-1">
                            <span>Número</span>
                            @if($sortField === 'repair_number')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Problema</th>
                    <th wire:click="sortBy('status')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <div class="flex items-center space-x-1">
                            <span>Estado</span>
                            @if($sortField === 'status')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th wire:click="sortBy('received_at')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                        <div class="flex items-center space-x-1">
                            <span>Recibido</span>
                            @if($sortField === 'received_at')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($sortDirection === 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Técnico</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($repairs as $repair)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $repair->repair_number }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $repair->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $repair->customer_email }}</div>
                            <div class="text-sm text-gray-500">{{ $repair->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $repair->device_type }}</div>
                            <div class="text-sm text-gray-500">{{ $repair->brand }} {{ $repair->model }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $repair->issue_description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($repair->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($repair->status === 'diagnosed') bg-blue-100 text-blue-800
                                @elseif($repair->status === 'approved') bg-purple-100 text-purple-800
                                @elseif($repair->status === 'in_progress') bg-orange-100 text-orange-800
                                @elseif($repair->status === 'completed') bg-green-100 text-green-800
                                @elseif($repair->status === 'delivered') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $repair->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $repair->received_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $repair->technician?->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openDetailModal({{ $repair->id }})"
                               class="text-indigo-600 hover:text-indigo-900 transition">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay reparaciones</h3>
                            <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva reparación.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $repairs->links() }}
    </div>

    <!-- MODAL CREAR REPARACIÓN -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showCreateModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeCreateModal"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="createRepair">
                        <div class="bg-white px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Nueva Reparación</h3>
                                <button type="button" wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="bg-white px-6 py-4 space-y-4 max-h-96 overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nombre del Cliente *</label>
                                    <input type="text" wire:model="customer_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email *</label>
                                    <input type="email" wire:model="customer_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('customer_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono *</label>
                                    <input type="text" wire:model="customer_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('customer_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de Dispositivo *</label>
                                    <input type="text" wire:model="device_type" placeholder="Laptop, Smartphone, etc." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('device_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Marca</label>
                                    <input type="text" wire:model="brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Modelo</label>
                                    <input type="text" wire:model="model" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de Serie</label>
                                    <input type="text" wire:model="serial_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Costo Estimado</label>
                                    <input type="number" step="0.01" wire:model="estimated_cost" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Entrega Estimada</label>
                                    <input type="date" wire:model="estimated_delivery" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Descripción del Problema *</label>
                                <textarea wire:model="issue_description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                @error('issue_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" wire:click="closeCreateModal" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">
                                Crear Reparación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL DETALLES -->
    @if($showDetailModal && $selectedRepair)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeDetailModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <!-- Header -->
                    <div class="bg-white px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Detalle de Reparación</h3>
                                <p class="text-sm text-gray-500">{{ $selectedRepair->repair_number }}</p>
                            </div>
                            <button type="button" wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="bg-white px-6 py-4 max-h-[75vh] overflow-y-auto space-y-6">

                        <!-- ===== PANEL CAMBIO DE ESTADO ===== -->
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-indigo-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Cambiar Estado
                            </h4>

                            {{-- Mensaje de éxito --}}
                            @if($showStatusChangeSuccess)
                                <div class="mb-3 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 px-3 py-2 rounded-md text-sm">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Estado actualizado correctamente. Se notificó al cliente por correo.
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                                <div>
                                    <label class="block text-xs font-medium text-indigo-800 mb-1">Nuevo estado</label>
                                    <select wire:model="newStatus"
                                            class="block w-full border-indigo-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        <option value="pending">⏳ Pendiente</option>
                                        <option value="diagnosed">🔍 Diagnosticada</option>
                                        <option value="approved">✅ Aprobada</option>
                                        <option value="in_progress">🔧 En Progreso</option>
                                        <option value="completed">🎉 Completada</option>
                                        <option value="delivered">📦 Entregada</option>
                                        <option value="cancelled">❌ Cancelada</option>
                                    </select>
                                    @error('newStatus') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-indigo-800 mb-1">Notas (opcional)</label>
                                    <input type="text"
                                           wire:model="statusChangeNotes"
                                           placeholder="Ej: Esperando repuesto..."
                                           class="block w-full border-indigo-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>
                                <div>
                                    <button wire:click="updateStatus"
                                            wire:loading.attr="disabled"
                                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white rounded-md text-sm font-medium transition">
                                        <span wire:loading.remove wire:target="updateStatus">
                                            Actualizar estado
                                        </span>
                                        <span wire:loading wire:target="updateStatus" class="flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Guardando...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- ===== FIN PANEL CAMBIO DE ESTADO ===== --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información del Cliente -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Cliente</h4>
                                <dl class="space-y-1">
                                    <div>
                                        <dt class="text-xs text-gray-500">Nombre</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->customer_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->customer_email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Teléfono</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->customer_phone }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Información del Equipo -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Equipo</h4>
                                <dl class="space-y-1">
                                    <div>
                                        <dt class="text-xs text-gray-500">Dispositivo</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->device_type }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Marca/Modelo</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->brand }} {{ $selectedRepair->model }}</dd>
                                    </div>
                                    @if($selectedRepair->serial_number)
                                    <div>
                                        <dt class="text-xs text-gray-500">Serie</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->serial_number }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>

                            <!-- Problema -->
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Problema Reportado</h4>
                                <p class="text-sm text-gray-700">{{ $selectedRepair->issue_description }}</p>
                            </div>

                            <!-- Información Adicional -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Información</h4>
                                <dl class="space-y-1">
                                    <div>
                                        <dt class="text-xs text-gray-500">Estado actual</dt>
                                        <dd class="mt-0.5">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($selectedRepair->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($selectedRepair->status === 'diagnosed') bg-blue-100 text-blue-800
                                                @elseif($selectedRepair->status === 'approved') bg-purple-100 text-purple-800
                                                @elseif($selectedRepair->status === 'in_progress') bg-orange-100 text-orange-800
                                                @elseif($selectedRepair->status === 'completed') bg-green-100 text-green-800
                                                @elseif($selectedRepair->status === 'delivered') bg-gray-100 text-gray-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $selectedRepair->status_label }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500">Fecha Recibido</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->received_at->format('d/m/Y') }}</dd>
                                    </div>
                                    @if($selectedRepair->estimated_delivery)
                                    <div>
                                        <dt class="text-xs text-gray-500">Entrega Estimada</dt>
                                        <dd class="text-sm text-gray-900">{{ $selectedRepair->estimated_delivery->format('d/m/Y') }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>

                            <!-- Costos -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Costos</h4>
                                <dl class="space-y-1">
                                    @if($selectedRepair->estimated_cost)
                                    <div>
                                        <dt class="text-xs text-gray-500">Costo Estimado</dt>
                                        <dd class="text-sm text-gray-900">${{ number_format($selectedRepair->estimated_cost, 2) }}</dd>
                                    </div>
                                    @endif
                                    @if($selectedRepair->final_cost)
                                    <div>
                                        <dt class="text-xs text-gray-500">Costo Final</dt>
                                        <dd class="text-sm font-medium text-gray-900">${{ number_format($selectedRepair->final_cost, 2) }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>

                            <!-- Historial de Estados -->
                            @if($selectedRepair->statusHistory->count() > 0)
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Historial de Estados</h4>
                                <div class="flow-root">
                                    <ul class="-mb-8">
                                        @foreach($selectedRepair->statusHistory as $history)
                                            <li>
                                                <div class="relative pb-8">
                                                    @if(!$loop->last)
                                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                    @endif
                                                    <div class="relative flex space-x-3">
                                                        <div>
                                                            <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white">
                                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div>
                                                                <p class="text-sm text-gray-500">
                                                                    Cambió a <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $history->status_to)) }}</span>
                                                                </p>
                                                                <p class="mt-0.5 text-xs text-gray-500">
                                                                    {{ $history->created_at->format('d/m/Y H:i') }} — {{ $history->user?->name ?? 'Sistema' }}
                                                                </p>
                                                            </div>
                                                            @if($history->notes)
                                                                <div class="mt-2 text-sm text-gray-700">
                                                                    <p>{{ $history->notes }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-between">
                        <button type="button" wire:click="confirmDelete({{ $selectedRepair->id }})"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium">
                            Eliminar
                        </button>
                        <button type="button" wire:click="closeDetailModal"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL CONFIRMAR ELIMINACIÓN -->
    @if($showDeleteModal && $repairToDelete)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeDeleteModal"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Reparación</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de eliminar la reparación <strong>{{ $repairToDelete->repair_number }}</strong>?
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="deleteRepair"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button type="button" wire:click="closeDeleteModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>