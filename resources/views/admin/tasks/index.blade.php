<x-app-layout>
{{-- 1. Header con breadcrumbs e icono -----------------------------}}

{{-- 2. Área de contenido ------------------------------------------}}
<div class="h-full p-6 lg:p-8">
    <div class="max-w-full mx-auto space-y-6 h-full flex flex-col">

        {{-- 2.1 Filtros + crear ------------------------------------}}
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl
                    rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30
                    px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('admin.tasks.index') }}" class="flex flex-col sm:flex-row gap-3 sm:gap-4 flex-1">
                {{-- Buscador --}}
                <input type="text"
                       name="search"
                       placeholder="Buscar por título..."
                       value="{{ request('search') }}"
                       class="w-full sm:w-80 rounded-lg bg-gray-50 dark:bg-gray-900
                              border-gray-300 dark:border-gray-600
                              text-gray-800 dark:text-gray-200
                              focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                {{-- Filtro prioridad --}}
                <select name="priority"
                        class="rounded-lg bg-gray-50 dark:bg-gray-900
                               border-gray-300 dark:border-gray-600
                               text-gray-800 dark:text-gray-200
                               focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                    <option value="">Todas las prioridades</option>
                    <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                </select>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white
                               bg-indigo-500 hover:bg-indigo-600
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                               dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar
                </button>
            </form>
            <div class="flex gap-3">
                <button onclick="openExportModal()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white
                               bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                               dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Exportar PDF
                </button>
                <a href="{{ route('admin.tasks.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white
                          bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                          dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear Tarea
                </a>
            </div>
        </div>

        {{-- 2.2 Tabla responsive -----------------------------------}}
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl
                    rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30
                    overflow-hidden flex-1 flex flex-col">
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Prioridad</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Asignado a</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Creado por</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($tasks as $task)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($task->description, 50) }}</td>

                            {{-- Prioridad con badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $priorityColors = [
                                        'alta'   => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300',
                                        'media'  => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                        'baja'   => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                    ];
                                    $color = $priorityColors[strtolower($task->priority)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>

                            {{-- Estado con badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pendiente'  => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'en progreso'=> 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                        'completada' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                    ];
                                    $sc = $statusColors[strtolower($task->status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $task->assignedTo->name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $task->createdBy->name ?? '—' }}</td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.tasks.show', $task->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                              bg-blue-50 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300
                                              hover:bg-blue-100 dark:hover:bg-blue-500/30 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                              bg-indigo-50 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300
                                              hover:bg-indigo-100 dark:hover:bg-indigo-500/30 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta tarea?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                                       bg-red-50 dark:bg-red-500/20 text-red-700 dark:text-red-300
                                                       hover:bg-red-100 dark:hover:bg-red-500/30 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal para exportar PDF --}}
<div id="exportModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4" x-data="{ open: false }">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Exportar Reporte PDF
            </h3>
            <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.tasks.export-pdf') }}" method="GET" class="space-y-5">
            <div>
                <label for="month" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Mes
                </label>
                <select id="month" name="month" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
                    <option value="">Seleccionar mes</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12" selected>Diciembre</option>
                </select>
            </div>

            <div>
                <label for="year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Año
                </label>
                <select id="year" name="year" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
                    <option value="">Seleccionar año</option>
                    @php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= 2020; $y--) {
                            echo "<option value=\"$y\"" . ($y == $currentYear ? ' selected' : '') . ">$y</option>";
                        }
                    @endphp
                </select>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        <p class="font-semibold mb-1">Información</p>
                        <p>Se exportarán únicamente las tareas <strong>finalizadas</strong> durante el mes y año seleccionado.</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeExportModal()"
                        class="flex-1 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 font-semibold shadow-lg hover:shadow-xl transition">
                    Generar PDF
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openExportModal() {
        document.getElementById('exportModal').classList.remove('hidden');
        document.getElementById('exportModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeExportModal() {
        document.getElementById('exportModal').classList.add('hidden');
        document.getElementById('exportModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
        }
    });
</script>
</x-app-layout>