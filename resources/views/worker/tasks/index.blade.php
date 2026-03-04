<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#F4F6FF] dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-[#4F46E5] dark:text-indigo-400 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-gray-100 tracking-tight">Mis Tareas Asignadas</h2>
                <p class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">Gestiona y visualiza las tareas que te han sido asignadas.</p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 lg:p-8 bg-slate-50 dark:bg-[#18191A] min-h-screen">
        <div class="max-w-full mx-auto space-y-6">
            
            <!-- Filter Bar -->
            <div class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-sm border border-slate-200/60 dark:border-[#3A3B3C] p-4 md:p-5">
                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-5 w-full">
                    
                    <!-- Search & Actions Form -->
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-4 w-full flex-wrap">
                        <form method="GET" action="{{ route('worker.tasks.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto flex-grow">
                            
                            <!-- Search Input -->
                            <div class="relative w-full sm:w-64 lg:w-96 flex-grow">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 dark:text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar título o descripción..." 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 placeholder-slate-400/80 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm">
                                @if(request('search'))
                                    <a href="{{ route('worker.tasks.index', array_filter(request()->except('search'))) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#4F46E5] transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                @endif
                            </div>
                            
                            <!-- Status Select -->
                            <div class="flex items-center gap-2 w-full sm:w-auto max-sm:mt-1 flex-shrink-0">
                                <select name="status" class="w-full sm:w-[150px] pl-3.5 pr-8 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239CA3AF%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.75rem_auto] bg-[position:right_0.8rem_center] bg-no-repeat cursor-pointer">
                                    <option value="">Estado</option>
                                    <option value="asignado" {{ request('status') == 'asignado' ? 'selected' : '' }}>Asignado</option>
                                    <option value="en progreso" {{ request('status') == 'en progreso' ? 'selected' : '' }}>En progreso</option>
                                    <option value="realizada" {{ request('status') == 'realizada' ? 'selected' : '' }}>Realizada</option>
                                    <option value="finalizada" {{ request('status') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                </select>
                            </div>

                            <!-- Priority & Submit Group -->
                            <div class="flex items-center gap-2 w-full sm:w-auto max-sm:mt-1 flex-shrink-0">
                                <!-- Priority Select -->
                                <select name="priority" class="w-full sm:w-[130px] pl-3.5 pr-8 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239CA3AF%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.75rem_auto] bg-[position:right_0.8rem_center] bg-no-repeat cursor-pointer">
                                    <option value="">Prioridad</option>
                                    <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                                </select>
                                
                                <!-- Submit Button -->
                                <button type="submit" class="flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-slate-700 dark:text-gray-200 rounded-xl transition-colors font-medium text-[0.85rem] shadow-sm flex-shrink-0" title="Buscar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                                
                                <!-- Clear Button -->
                                @if(request()->anyFilled(['search', 'status', 'priority']))
                                    <a href="{{ route('worker.tasks.index') }}" class="flex items-center justify-center px-4 py-2.5 bg-[#F4F6FF] hover:bg-[#E0E7FF] dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40 text-[#4F46E5] dark:text-indigo-400 rounded-xl transition-colors font-medium text-[0.85rem] gap-1.5 shadow-sm flex-shrink-0" title="Limpiar filtros">
                                        <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-sm border border-slate-200/60 dark:border-[#3A3B3C] overflow-hidden flex flex-col min-h-[500px]">
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
                                            <a href="{{ route('worker.tasks.show', $task->id) }}" class="p-2 hover:bg-slate-100 dark:bg-[#3A3B3C] hover:text-slate-700 dark:text-gray-200 rounded-lg transition-colors" title="Ver detalle">
                                                <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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

                <!-- Footer Pagination -->
                @if ($tasks->hasPages() || $tasks->total() > 0)
                <div class="px-6 py-5 border-t border-slate-100 dark:border-[#3A3B3C] flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto style-pagination-none">
                    <div class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] font-medium whitespace-nowrap">
                        Mostrando <span class="font-bold text-slate-700 dark:text-gray-200">{{ $tasks->firstItem() ?? 0 }}</span> a <span class="font-bold text-slate-700 dark:text-gray-200">{{ $tasks->lastItem() ?? 0 }}</span> de <span class="font-bold text-slate-700 dark:text-gray-200">{{ $tasks->total() }}</span> tareas
                    </div>
                    
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto justify-end">
                        {{-- Botón Anterior --}}
                        @if ($tasks->onFirstPage())
                            <span class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        @else
                            <a href="{{ $tasks->previousPageUrl() }}" class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] hover:border-slate-300 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        @endif

                        {{-- Páginas Numeradas --}}
                        <div class="flex items-center gap-1.5 mx-1">
                            @foreach ($tasks->getUrlRange(max(1, $tasks->currentPage() - 1), min($tasks->lastPage(), $tasks->currentPage() + 1)) as $page => $url)
                                @if ($page == $tasks->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#1A202C] text-white text-[0.85rem] font-bold shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-transparent text-slate-600 dark:text-gray-300 hover:border-slate-200 dark:border-[#3A3B3C] hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] text-[0.85rem] font-semibold transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Botón Siguiente --}}
                        @if ($tasks->hasMorePages())
                            <a href="{{ $tasks->nextPageUrl() }}" class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] hover:border-slate-300 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>