<x-app-layout>
    <div class="p-6 lg:p-8 bg-slate-50 dark:bg-[#18191A] min-h-screen">
        <div class="max-w-full mx-auto space-y-6">
            
            <!-- Header Card -->
            <div class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-sm border border-slate-200/60 dark:border-[#3A3B3C] p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-[#F4F6FF] rounded-2xl flex items-center justify-center text-[#4F46E5] flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[1.35rem] font-bold text-slate-800 dark:text-gray-100 tracking-tight">Gestión de Tareas</h2>
                            <p class="text-sm text-slate-500 dark:text-[#B0B3B8] mt-1">
                                Supervisa y organiza el flujo de trabajo del sistema.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col xl:flex-row items-center gap-4 w-full md:w-auto">
                        <form method="GET" action="{{ route('admin.tasks.index') }}" class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
                            <div class="relative flex-grow sm:w-64">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 dark:text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar título..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-[#242526] border border-slate-200/80 rounded-xl text-sm text-slate-700 dark:text-gray-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-300 transition-colors">
                            </div>
                            <div class="flex gap-2 w-full sm:w-auto">
                                <select name="priority" class="w-full sm:w-auto px-4 py-2.5 bg-white dark:bg-[#242526] border border-slate-200/80 rounded-xl text-sm text-slate-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-300 transition-colors flex-grow">
                                    <option value="">Prioridad</option>
                                    <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                                </select>
                                <button type="submit" class="sm:hidden flex items-center justify-center px-4 py-2.5 bg-slate-100 dark:bg-[#3A3B3C] hover:bg-slate-200 text-slate-600 dark:text-gray-300 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </div>
                            <button type="submit" class="hidden sm:flex items-center justify-center px-4 py-2.5 bg-slate-100 dark:bg-[#3A3B3C] hover:bg-slate-200 text-slate-600 dark:text-gray-300 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>

                        <div class="flex items-center gap-2 w-full xl:w-auto">
                            <button onclick="openExportModal()" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-[#10B981] hover:bg-[#059669] text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm focus:ring-2 focus:ring-[#10B981]/50 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <span class="hidden sm:inline">Exportar</span> PDF
                            </button>
                            <button onclick="openModal('createTaskModal')" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-[#1A202C] hover:bg-[#2D3748] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Crear Tarea
                            </button>
                        </div>
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
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest hidden lg:table-cell min-w-[200px]">
                                    Participantes
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest min-w-[180px]">
                                    Estado & Prioridad
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest text-right min-w-[120px]">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70">
                            @forelse ($tasks as $task)
                                <tr class="hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 dark:bg-[#18191A] transition-colors group">
                                    <td class="px-6 py-5 relative">
                                        <div class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100 pr-4">{{ $task->title }}</div>
                                        <div class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-1 line-clamp-2 pr-4 leading-relaxed" title="{{ $task->description }}">{{ $task->description }}</div>
                                        <div class="lg:hidden mt-3 text-[0.8rem] flex items-center gap-2">
                                            <span class="text-slate-400 dark:text-[#9CA3AF]">Para:</span>
                                            <span class="font-medium bg-slate-100 dark:bg-[#3A3B3C] text-slate-700 dark:text-gray-200 px-2 py-0.5 rounded">{{ $task->assignedTo->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 hidden lg:table-cell align-top">
                                        <div class="text-[0.85rem] text-slate-700 dark:text-gray-200 mb-1.5 flex items-center gap-2">
                                            <span class="text-slate-400 dark:text-[#9CA3AF] text-[0.75rem] uppercase tracking-wider font-semibold">Para</span> 
                                            <span class="font-medium bg-slate-100/80 dark:bg-[#4E4F50] px-2.5 py-1 rounded-md">{{ $task->assignedTo->name ?? '—' }}</span>
                                        </div>
                                        <div class="text-[0.8rem] text-slate-400 dark:text-[#9CA3AF] flex items-center gap-2">
                                            <span class="text-slate-400 dark:text-[#9CA3AF]/70 text-[0.7rem] uppercase tracking-wider font-semibold">De</span>
                                            {{ $task->createdBy->name ?? '—' }}
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
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded {{ $priorityClass }} text-[0.7rem] font-bold ml-0.5">
                                                <div class="w-1.5 h-1.5 rounded-full currentColor bg-current"></div>
                                                PRIORIDAD {{ strtoupper($task->priority) }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-5 text-right align-top">
                                        <div class="flex items-center justify-end gap-1.5 text-slate-400 dark:text-[#9CA3AF] opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.tasks.show', $task->id) }}" class="p-2 hover:bg-slate-100 dark:bg-[#3A3B3C] hover:text-slate-700 dark:text-gray-200 rounded-lg transition-colors" title="Ver detalle">
                                                <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            @if(empty($task->initial_evidence_images) && empty($task->final_evidence_images))
                                                <button onclick="startEditTask({{ $task->id }})" class="p-2 hover:bg-[#F0F5FF] hover:text-[#2563EB] rounded-lg transition-colors" title="Editar tarea">
                                                    <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                            @else
                                                <button disabled class="p-2 text-slate-300 rounded-lg cursor-not-allowed" title="Edición bloqueada: Tarea con evidencia">
                                                    <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                </button>
                                            @endif
                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta tarea?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 hover:bg-[#FEF2F2] hover:text-[#DC2626] rounded-lg transition-colors cursor-pointer" title="Eliminar tarea">
                                                    <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center text-slate-500 dark:text-[#B0B3B8]">
                                        <div class="flex items-center justify-center flex-col">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            <span>No se encontraron tareas.</span>
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

    {{-- Modal para exportar PDF --}}
    <div id="exportModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4"
        x-data="{ open: false }">
        <div class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Exportar Reporte PDF
                </h3>
                <button onclick="closeExportModal()"
                    class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.tasks.export-pdf') }}" method="GET" class="space-y-5">
                <div>
                    <label for="month" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-2">
                        Mes
                    </label>
                    <select id="month" name="month" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
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
                    <label for="year" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-2">
                        Año
                    </label>
                    <select id="year" name="year" required
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
                        <option value="">Seleccionar año</option>
                        @php
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y >= 2020; $y--) {
                                echo "<option value=\"$y\"" . ($y == $currentYear ? ' selected' : '') . ">$y</option>";
                            }
                        @endphp
                    </select>
                </div>

                <div
                    class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-gray-700 dark:text-gray-200 dark:text-gray-300">
                            <p class="font-semibold mb-1">Información</p>
                            <p>Se exportarán únicamente las tareas <strong>finalizadas</strong> durante el mes y año
                                seleccionado.</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeExportModal()"
                        class="flex-1 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold transition">
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

    {{-- Modal para Crear Tarea --}}
    <div id="createTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                onclick="closeModal('createTaskModal')"></div>

            <div
                class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white dark:bg-[#242526] dark:bg-gray-800 px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">Crear Nueva Tarea</h3>
                        </div>
                        <button onclick="closeModal('createTaskModal')"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.tasks.store') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf

                        <div>
                            <label for="task_title"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Título
                                *</label>
                            <input id="task_title" name="title" type="text" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Título de la tarea">
                        </div>

                        <div>
                            <label for="task_description"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea id="task_description" name="description" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Descripción de la tarea"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="task_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Fecha
                                    Límite *</label>
                                <input id="task_deadline" name="deadline_at" type="date" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label for="task_location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Ubicación
                                    *</label>
                                <input id="task_location" name="location" type="text" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Ubicación de la tarea">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="task_priority"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Prioridad
                                    *</label>
                                <select id="task_priority" name="priority" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="task_assigned_to"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Asignar
                                    a</label>
                                <select id="task_assigned_to" name="assigned_to"
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Selecciona un trabajador</option>
                                    @foreach ($workers as $worker)
                                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="task_reference_images"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Imágenes de
                                Referencia (Opcional)</label>
                            <input id="task_reference_images" name="reference_images[]" type="file" accept="image/*"
                                multiple
                                class="block w-full text-sm text-gray-900 dark:text-gray-100 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none">
                            <p class="mt-1 text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">PNG, JPG, GIF hasta 2MB cada una.
                            </p>
                        </div>

                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                            <button type="button" onclick="closeModal('createTaskModal')"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all shadow-lg">Crear
                                Tarea</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para Editar Tarea --}}
    <div id="editTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                onclick="closeModal('editTaskModal')"></div>

            <div
                class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white dark:bg-[#242526] dark:bg-gray-800 px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <h3 id="editTaskModalTitle" class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">Editar
                                Tarea</h3>
                        </div>
                        <button onclick="closeModal('editTaskModal')"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="editTaskForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="edit_task_title"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Título
                                *</label>
                            <input id="edit_task_title" name="title" type="text" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="edit_task_description"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea id="edit_task_description" name="description" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_task_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Fecha
                                    Límite *</label>
                                <input id="edit_task_deadline" name="deadline_at" type="date" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="edit_task_location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Ubicación
                                    *</label>
                                <input id="edit_task_location" name="location" type="text" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_task_priority"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Prioridad
                                    *</label>
                                <select id="edit_task_priority" name="priority" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="edit_task_status"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Estado
                                    *</label>
                                <select id="edit_task_status" name="status" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="pendiente">Pendiente</option>
                                    <option value="asignado">Asignado</option>
                                    <option value="en progreso">En Progreso</option>
                                    <option value="realizada">Realizada</option>
                                    <option value="finalizada">Finalizada</option>
                                    <option value="cancelada">Cancelada</option>
                                    <option value="incompleta">Incompleta</option>
                                    <option value="retraso en proceso">Retraso en Proceso</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="edit_task_assigned_to"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Asignar
                                a</label>
                            <select id="edit_task_assigned_to" name="assigned_to"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona un trabajador</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                            <button type="button" onclick="closeModal('editTaskModal')"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">Cancelar</button>
                            <button id="editTaskSubmitBtn" type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all shadow-lg">Guardar
                                Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

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
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeExportModal();
                closeModal('createTaskModal');
                closeModal('editTaskModal');
            }
        });

        // Store tasks in a global variable for easy access
        const tasksData = @json($tasks->items());

        function startEditTask(taskId) {
            try {
                // Find the task by ID. Ensure strict comparison matches types (int vs string)
                const task = tasksData.find(t => t.id == taskId);

                if (!task) {
                    console.error('Task not found for ID:', taskId);
                    alert('Error: No se encontró la información de la tarea.');
                    return;
                }

                console.log('Editing task:', task);

                const isFinished = task.status.toLowerCase() === 'finalizada';
                const form = document.getElementById('editTaskForm');
                const title = document.getElementById('editTaskModalTitle');
                const submitBtn = document.getElementById('editTaskSubmitBtn');

                if (!form) {
                    console.error('Edit form not found');
                    return;
                }

                form.action = `/admin/tasks/${task.id}`;

                // Update UI based on status
                if (isFinished) {
                    title.innerText = 'Ver Tarea (Finalizada)';
                    submitBtn.classList.add('hidden');
                } else {
                    title.innerText = 'Editar Tarea';
                    submitBtn.classList.remove('hidden');
                }

                // Enable/Disable all form fields
                const fields = form.querySelectorAll('input, select, textarea');
                fields.forEach(field => {
                    field.disabled = isFinished;
                });

                // Populate fields
                document.getElementById('edit_task_title').value = task.title;
                document.getElementById('edit_task_description').value = task.description || '';

                // Format date for input type="date"
                if (task.deadline_at) {
                    try {
                        const date = new Date(task.deadline_at);
                        // Check if date is valid
                        if (!isNaN(date.getTime())) {
                            const formattedDate = date.toISOString().split('T')[0];
                            document.getElementById('edit_task_deadline').value = formattedDate;
                        }
                    } catch (e) {
                        console.error('Error formatting date:', e);
                    }
                }

                document.getElementById('edit_task_location').value = task.location;
                // For selects, ensure value exists or handle default
                const prioritySelect = document.getElementById('edit_task_priority');
                if (prioritySelect) prioritySelect.value = task.priority;

                const statusSelect = document.getElementById('edit_task_status');
                if (statusSelect) statusSelect.value = task.status;

                const workerSelect = document.getElementById('edit_task_assigned_to');
                if (workerSelect) {
                    // Logic: if task.assigned_to is an object (relationship), use its id.
                    // If it's just the ID (number/string), use it directly.
                    if (task.assigned_to && typeof task.assigned_to === 'object') {
                        workerSelect.value = task.assigned_to.id;
                    } else {
                        workerSelect.value = task.assigned_to || '';
                    }
                }

                openModal('editTaskModal');
            } catch (error) {
                console.error('Error in startEditTask:', error);
                alert('Error al abrir el modal de edición. Por favor, revisa la consola para más detalles.');
            }
        }
    </script>
</x-app-layout>