<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Auditoría</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Historial de Auditoría</h1>

        {{-- Filtros --}}
        <form method="GET" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Evento</label>
                <select name="event" class="border rounded px-3 py-2">
                    <option value="">Todos</option>
                    @foreach($events as $event)
                        <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                            {{ $event }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Modelo</label>
                <select name="subject_type" class="border rounded px-3 py-2">
                    <option value="">Todos</option>
                    @foreach($subjectTypes as $type)
                        <option value="{{ $type }}" {{ request('subject_type') == $type ? 'selected' : '' }}>
                            {{ class_basename($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">ID usuario</label>
                <input type="text" name="causer_id" placeholder="Ej. 1"
                       value="{{ request('causer_id') }}" class="border rounded px-3 py-2 w-28">
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Desde</label>
                <input type="date" name="from" value="{{ request('from') }}" class="border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Hasta</label>
                <input type="date" name="to" value="{{ request('to') }}" class="border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filtrar
            </button>
            <a href="{{ route('audit.index') }}" class="text-gray-600 px-4 py-2 hover:underline">
                Limpiar
            </a>
        </form>

        {{-- Tabla --}}
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Evento</th>
                        <th class="px-4 py-3 text-left">Modelo</th>
                        <th class="px-4 py-3 text-left">Cambios</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $activity->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $activity->causer?->name ?? 'Sistema' }}
                                @if($activity->causer_id)
                                    <span class="text-xs text-gray-500">(ID {{ $activity->causer_id }})</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($activity->event == 'created') bg-green-100 text-green-800
                                    @elseif($activity->event == 'updated') bg-yellow-100 text-yellow-800
                                    @elseif($activity->event == 'deleted') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $activity->event }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                {{ class_basename($activity->subject_type) }}
                                <span class="text-gray-500">#{{ $activity->subject_id }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                @php
                                    $props = is_string($activity->properties) 
                                        ? json_decode($activity->properties, true) 
                                        : $activity->properties->toArray();
                                    $old = $props['old'] ?? [];
                                    $new = $props['attributes'] ?? [];
                                @endphp

                                @if(!empty($old) && !empty($new))
                                    @foreach($new as $key => $newValue)
                                        @if(array_key_exists($key, $old) && $old[$key] != $newValue)
                                            <div class="mb-1">
                                                <strong>{{ $key }}:</strong>
                                                <span class="text-red-600 line-through">{{ $old[$key] ?? '—' }}</span>
                                                <span class="text-gray-400">→</span>
                                                <span class="text-green-700">{{ $newValue }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-gray-500">{{ $activity->description }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                No hay registros de auditoría.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $activities->links() }}</div>
    </div>
</body>
</html>