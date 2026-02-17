<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Mis Tareas Asignadas') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 lg:p-8">
        <div class="max-w-full mx-auto space-y-6">

            {{-- Barra de búsqueda y filtros --}}
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                <form method="GET" action="{{ route('worker.tasks.index') }}" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Buscador --}}
                        <div class="relative flex-1">
                            <input type="text" name="search" placeholder="Buscar por título o descripción..."
                                value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-900
                                          border-gray-300 dark:border-gray-600
                                          text-gray-800 dark:text-gray-200
                                          focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400
                                          focus:border-blue-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="absolute left-4 top-3.5">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('worker.tasks.index', array_filter(request()->except('search'))) }}"
                                    class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    title="Limpiar búsqueda">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        {{-- Filtro estado --}}
                        <select name="status" class="w-full lg:w-48 rounded-lg bg-gray-50 dark:bg-gray-900
                                       border-gray-300 dark:border-gray-600
                                       text-gray-800 dark:text-gray-200
                                       focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400
                                       focus:border-blue-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <option value="">Todos los estados</option>
                            <option value="asignado" {{ request('status') == 'asignado' ? 'selected' : '' }}>Asignado
                            </option>
                            <option value="en progreso" {{ request('status') == 'en progreso' ? 'selected' : '' }}>En
                                progreso</option>
                            <option value="realizada" {{ request('status') == 'realizada' ? 'selected' : '' }}>Realizada
                            </option>
                            <option value="finalizada" {{ request('status') == 'finalizada' ? 'selected' : '' }}>
                                Finalizada</option>
                        </select>

                        {{-- Filtro prioridad --}}
                        <select name="priority" class="w-full lg:w-48 rounded-lg bg-gray-50 dark:bg-gray-900
                                       border-gray-300 dark:border-gray-600
                                       text-gray-800 dark:text-gray-200
                                       focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400
                                       focus:border-blue-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <option value="">Todas las prioridades</option>
                            <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Media</option>
                            <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-white
                                           bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                           dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </button>
                            @if(request()->anyFilled(['search', 'status', 'priority']))
                                <a href="{{ route('worker.tasks.index') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-gray-700 dark:text-gray-300
                                                              bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600
                                                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500
                                                              dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Limpiar filtros
                                </a>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            @if(request()->anyFilled(['search', 'status', 'priority']))
                                Se encontraron <strong class="text-gray-900 dark:text-white">{{ $tasks->count() }}</strong>
                                resultado(s)
                            @else
                                Total de tareas: <strong
                                    class="text-gray-900 dark:text-white">{{ $tasks->count() }}</strong>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabla de tareas --}}
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50">
                {{-- VISTA DE ESCRITORIO (Tabla) --}}
                {{-- VISTA DE ESCRITORIO (Tabla) --}}
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead
                            class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/70 dark:to-gray-800/70 backdrop-blur-sm">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Título</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Descripción</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Prioridad</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Estado</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Fecha Límite</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Asignado por</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($tasks as $task)
                                <tr class="group hover:bg-blue-50/50 dark:hover:bg-gray-700/30 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $task->title }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                            {{ Str::limit($task->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'alta' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300',
                                                'media' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                                'baja' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                            ];
                                            $color = $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'asignado' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                                'en progreso' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                                'realizada' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300',
                                                'finalizada' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                                'cancelada' => 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300',
                                            ];
                                            $color = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            @if($task->deadline_at < now() && !in_array($task->status, ['finalizada', 'cancelada', 'realizada']))
                                                <span
                                                    class="text-red-600 dark:text-red-400 font-medium">{{ $task->deadline_at->format('d/m/Y') }}</span>
                                                <span class="text-xs text-red-500 block">Vencida</span>
                                            @elseif($task->deadline_at <= now()->addDays(7) && !in_array($task->status, ['finalizada', 'cancelada', 'realizada']))
                                                <span
                                                    class="text-yellow-600 dark:text-yellow-400 font-medium">{{ $task->deadline_at->format('d/m/Y') }}</span>
                                                <span class="text-xs text-yellow-500 block">Próxima</span>
                                            @else
                                                {{ $task->deadline_at->format('d/m/Y') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($task->createdBy->name ?? 'N/A', 0, 1) }}
                                            </div>
                                            <span
                                                class="text-sm text-gray-600 dark:text-gray-300">{{ $task->createdBy->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('worker.tasks.show', $task->id) }}"
                                            class="inline-flex items-center gap-1 px-4 py-2 rounded-lg
                                                                      bg-blue-50 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300
                                                                      hover:bg-blue-100 dark:hover:bg-blue-500/30 transition shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver / Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            @if(request()->anyFilled(['search', 'status', 'priority']))
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No se
                                                    encontraron resultados</h3>
                                                <p class="text-gray-600 dark:text-gray-400 mb-4">No hay tareas que coincidan con
                                                    los filtros aplicados.</p>
                                                <a href="{{ route('worker.tasks.index') }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white bg-blue-500 hover:bg-blue-600 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Limpiar filtros
                                                </a>
                                            @else
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No tienes
                                                    tareas asignadas</h3>
                                                <p class="text-gray-600 dark:text-gray-400">Las tareas que te asignen aparecerán
                                                    aquí.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</x-app-layout>