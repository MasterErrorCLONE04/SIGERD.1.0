<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-[#F4F6FF] dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-[#4F46E5] dark:text-indigo-400 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                class="bg-white dark:bg-[#242526] rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C] p-6">
                <form method="GET" action="{{ route('worker.tasks.index') }}" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Buscador --}}
                        <div class="relative flex-1">
                            <input type="text" name="search" placeholder="Buscar por título o descripción..."
                                value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-50 dark:bg-[#18191A]
                                          border-gray-300 dark:border-[#3A3B3C]
                                          text-gray-800 dark:text-gray-100 dark:text-gray-200
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
                                    class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300"
                                    title="Limpiar búsqueda">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        {{-- Filtro estado --}}
                        <select name="status" class="w-full lg:w-48 rounded-lg bg-gray-50 dark:bg-[#18191A]
                                       border-gray-300 dark:border-[#3A3B3C]
                                       text-gray-800 dark:text-gray-100 dark:text-gray-200
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
                        <select name="priority" class="w-full lg:w-48 rounded-lg bg-gray-50 dark:bg-[#18191A]
                                       border-gray-300 dark:border-[#3A3B3C]
                                       text-gray-800 dark:text-gray-100 dark:text-gray-200
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
                                           bg-[#1A202C] hover:bg-[#2D3748]
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </button>
                            @if(request()->anyFilled(['search', 'status', 'priority']))
                                <a href="{{ route('worker.tasks.index') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-white font-medium
                                                              bg-[#1A202C] hover:bg-[#2D3748]
                                                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200
                                                              dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Limpiar filtros
                                </a>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">
                            @if(request()->anyFilled(['search', 'status', 'priority']))
                                Se encontraron <strong class="text-gray-900 dark:text-gray-100 dark:text-white">{{ $tasks->count() }}</strong>
                                resultado(s)
                            @else
                                Total de tareas: <strong
                                    class="text-gray-900 dark:text-gray-100 dark:text-white">{{ $tasks->count() }}</strong>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabla de tareas --}}
            <div
                class="bg-white dark:bg-[#242526] rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C]">
                {{-- VISTA DE ESCRITORIO (Tabla) --}}
                {{-- VISTA DE ESCRITORIO (Tabla) --}}
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-[#3A3B3C]">
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest min-w-[300px]">
                                    Tarea
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest hidden lg:table-cell min-w-[150px]">
                                    Asignado por
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest min-w-[150px]">
                                    Estado & Prioridad
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest min-w-[130px]">
                                    Fecha Límite
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest text-right min-w-[80px]">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70">
                            @forelse($tasks as $task)
                                <tr class="hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 dark:bg-[#18191A] transition-colors group">
                                    <td class="px-6 py-5 relative">
                                        <div class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100 pr-4">{{ $task->title }}</div>
                                        <div class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-1 line-clamp-2 pr-4 leading-relaxed" title="{{ $task->description }}">{{ $task->description }}</div>
                                        <div class="lg:hidden mt-3 text-[0.8rem] flex items-center gap-2">
                                            <span class="text-slate-400 dark:text-[#9CA3AF]">De:</span>
                                            <span class="font-medium bg-slate-100 dark:bg-[#3A3B3C] text-slate-700 dark:text-gray-200 px-2 py-0.5 rounded">{{ $task->createdBy->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 hidden lg:table-cell align-top">
                                        <div class="flex items-center gap-2.5 mt-1">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-[#1A202C] to-slate-700 flex items-center justify-center text-white text-[0.7rem] font-bold shadow-sm">
                                                {{ substr($task->createdBy->name ?? 'N', 0, 1) }}
                                            </div>
                                            <span class="text-[0.85rem] font-semibold text-slate-700 dark:text-gray-200">{{ $task->createdBy->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col gap-2.5 items-start">
                                            {{-- Estado Badge --}}
                                            @php
                                                $status = strtolower($task->status);
                                                $statusClass = match($status) {
                                                    'completada', 'finalizada', 'realizada' => 'bg-[#ECFDF5] text-[#059669] ring-1 ring-[#059669]/20',
                                                    'en progreso' => 'bg-[#EFF6FF] text-[#2563EB] ring-1 ring-[#2563EB]/20',
                                                    'asignado' => 'bg-[#F0FDF4] text-[#16A34A] ring-1 ring-[#16A34A]/20',
                                                    'cancelada' => 'bg-[#FEF2F2] text-[#DC2626] ring-1 ring-[#DC2626]/20',
                                                    'retraso en proceso', 'incompleta' => 'bg-[#FFFBEB] text-[#D97706] ring-1 ring-[#D97706]/20',
                                                    default => 'bg-[#F1F5F9] text-[#475569] ring-1 ring-[#475569]/20'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[0.75rem] font-bold uppercase tracking-wider {{ $statusClass }}">
                                                {{ $task->status }}
                                            </span>

                                            {{-- Prioridad Badge --}}
                                            @php
                                                $priority = strtolower($task->priority);
                                                $priorityClass = match($priority) {
                                                    'alta' => 'text-[#EF4444] bg-[#FEF2F2]',
                                                    'media' => 'text-[#F59E0B] bg-[#FFFBEB]',
                                                    'baja' => 'text-[#10B981] bg-[#ECFDF5]',
                                                    default => 'text-slate-500 dark:text-[#B0B3B8] bg-slate-100 dark:bg-[#3A3B3C]'
                                                };
                                            @endphp
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded {{ $priorityClass }} text-[0.7rem] font-bold ml-0.5 mt-0.5">
                                                <div class="w-1.5 h-1.5 rounded-full currentColor bg-current"></div>
                                                PRIORIDAD {{ strtoupper($task->priority) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col gap-1 mt-1">
                                            @if($task->deadline_at < now() && !in_array($task->status, ['finalizada', 'cancelada', 'realizada']))
                                                <span class="text-[0.85rem] font-bold text-red-600 dark:text-red-400">{{ $task->deadline_at->format('d/m/Y') }}</span>
                                                <span class="text-[0.65rem] uppercase tracking-wider font-bold text-red-500">Vencida</span>
                                            @elseif($task->deadline_at <= now()->addDays(7) && !in_array($task->status, ['finalizada', 'cancelada', 'realizada']))
                                                <span class="text-[0.85rem] font-bold text-amber-600 dark:text-amber-400">{{ $task->deadline_at->format('d/m/Y') }}</span>
                                                <span class="text-[0.65rem] uppercase tracking-wider font-bold text-amber-500">Próxima</span>
                                            @else
                                                <span class="text-[0.85rem] font-medium text-slate-700 dark:text-gray-300">{{ $task->deadline_at->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right align-top">
                                        <div class="flex items-center justify-end gap-1.5 text-slate-400 dark:text-[#9CA3AF] opacity-80 group-hover:opacity-100 transition-opacity mt-1">
                                            <a href="{{ route('worker.tasks.show', $task->id) }}"
                                                class="flex items-center gap-2 px-3 py-1.5 bg-[#1A202C] hover:bg-[#2D3748] text-white rounded-lg transition-colors shadow-sm focus:ring-2 focus:ring-slate-200" title="Ver Detalle">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span class="text-[0.75rem] font-bold uppercase tracking-wider">Ver</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center text-slate-500 dark:text-[#B0B3B8]">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            @if(request()->anyFilled(['search', 'status', 'priority']))
                                                <h3 class="text-[0.95rem] font-bold text-slate-700 dark:text-gray-200 mb-1">No se encontraron resultados</h3>
                                                <p class="text-[0.85rem] text-slate-500 dark:text-[#9CA3AF] mb-4">No hay tareas que coincidan con los filtros aplicados.</p>
                                                <a href="{{ route('worker.tasks.index') }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white bg-[#1A202C] hover:bg-[#2D3748] transition shadow-sm focus:ring-2 focus:ring-slate-200 text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Limpiar filtros
                                                </a>
                                            @else
                                                <h3 class="text-[0.95rem] font-bold text-slate-700 dark:text-gray-200 mb-1">No tienes tareas asignadas</h3>
                                                <p class="text-[0.85rem] text-slate-500 dark:text-[#9CA3AF]">Las tareas que te asignen aparecerán aquí.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 border-t border-slate-200 dark:border-[#3A3B3C]">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>