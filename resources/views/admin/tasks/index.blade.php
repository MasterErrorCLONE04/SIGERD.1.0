<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#F4F6FF] dark:bg-[#3A3B3C] rounded-2xl flex items-center justify-center text-[#4F46E5] dark:text-indigo-400 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-gray-100 tracking-tight">Gestión de Tareas</h2>
                <p class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">Supervisa y organiza el flujo de trabajo del sistema.</p>
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
                        <form method="GET" action="{{ route('admin.tasks.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto flex-grow">
                            
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
                                    placeholder="Buscar título..." 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 placeholder-slate-400/80 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm">
                                @if(request('search'))
                                    <a href="{{ route('admin.tasks.index', array_filter(request()->except('search'))) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#4F46E5] transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                @endif
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
                                @if(request()->anyFilled(['search', 'priority']))
                                    <a href="{{ route('admin.tasks.index') }}" class="flex items-center justify-center px-4 py-2.5 bg-[#F4F6FF] hover:bg-[#E0E7FF] dark:bg-[#3A3B3C] dark:hover:bg-indigo-900/40 text-[#4F46E5] dark:text-indigo-400 rounded-xl transition-colors font-medium text-[0.85rem] gap-1.5 shadow-sm flex-shrink-0" title="Limpiar filtros">
                                        <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 w-full lg:w-auto lg:pl-4 lg:border-l border-slate-200 dark:border-[#3A3B3C] flex-shrink-0">
                            <button onclick="openExportModal()" class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-[#10B981] hover:bg-[#059669] text-white px-4 py-2.5 rounded-xl text-[0.85rem] font-medium transition-colors shadow-sm focus:ring-2 focus:ring-[#10B981]/50 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <span class="hidden sm:inline">Exportar PDF</span>
                                <span class="sm:hidden">Exportar</span>
                            </button>
                            <button onclick="openModal('createTaskModal')" class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-[#1A202C] hover:bg-[#2D3748] text-white px-5 py-2.5 rounded-xl text-[0.85rem] font-medium transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 whitespace-nowrap">
                                <svg class="w-4 h-4 !text-white dark:!text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
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
    @include('modals.admin-export-tasks')

    {{-- Modal para Crear Tarea --}}
    @include('modals.admin-create-task')

    {{-- Modal para Editar Tarea --}}
    @include('modals.admin-edit-task')

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

        // Reabrir modal de crear tarea si hay errores de validación (solo si no es edición)
        @if ($errors->any() && !old('_method'))
            document.addEventListener('DOMContentLoaded', function() {
                openModal('createTaskModal');
            });
        @endif

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

                // Cargar imágenes de referencia existentes a AlpineJS
                let existingImages = [];
                if (task.reference_images && Array.isArray(task.reference_images)) {
                    existingImages = task.reference_images.map(path => {
                        return { url: `/storage/${path}` };
                    });
                }
                window.dispatchEvent(new CustomEvent('loadEditTaskImages', {
                    detail: { images: existingImages }
                }));

                openModal('editTaskModal');
            } catch (error) {
                console.error('Error in startEditTask:', error);
                alert('Error al abrir el modal de edición. Por favor, revisa la consola para más detalles.');
            }
        }
    </script>
</x-app-layout>