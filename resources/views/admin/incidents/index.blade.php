<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#FFF1F2] dark:bg-rose-900/20 rounded-2xl flex items-center justify-center text-[#E11D48] dark:text-rose-400 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-gray-100 tracking-tight">Registro de Incidentes</h2>
                <p class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">Monitoreo y seguimiento de reportes en tiempo real.</p>
            </div>
        </div>
    </x-slot>

    <div class="p-6 lg:p-8 bg-slate-50 dark:bg-[#18191A] min-h-screen">
        <div class="max-w-full mx-auto space-y-6">
            
            <!-- Filter Bar -->
            <div class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-sm border border-slate-200/60 dark:border-[#3A3B3C] p-4 md:p-5">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                    
                    <!-- Info Section -->
                    <div class="flex items-center gap-3 px-2">
                        <div class="p-2.5 bg-[#F4F6FF] dark:bg-indigo-900/20 rounded-xl text-[#4F46E5] dark:text-indigo-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </div>
                        <div>
                            @if(request()->anyFilled(['search', 'created_at_from']))
                                <h3 class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100 tracking-tight">Resultados de búsqueda</h3>
                                <p class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">Se han encontrado {{ $incidents->total() }} incidente(s)</p>
                            @else
                                <h3 class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100 tracking-tight">Filtros de búsqueda</h3>
                                <p class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">Encuentra reportes rápidamente</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Search & Filter Form -->
                    <div class="flex items-center w-full lg:w-auto">
                        <form method="GET" action="{{ route('admin.incidents.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                            
                            <!-- Search Input -->
                            <div class="relative w-full sm:w-72 lg:w-80">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 dark:text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar por título o descripción..." 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 placeholder-slate-400/80 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm">
                                @if(request('search'))
                                    <a href="{{ route('admin.incidents.index', array_filter(request()->except('search'))) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#E11D48] transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                @endif
                            </div>
                            
                            <!-- Date & Actions Group -->
                            <div class="flex items-center gap-2 w-full sm:w-auto max-sm:mt-1">
                                <!-- Date Input -->
                                <input type="date" name="created_at_from" value="{{ request('created_at_from') }}" class="w-full sm:w-[140px] px-3.5 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm">
                                
                                <!-- Submit Button -->
                                <button type="submit" class="flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-slate-700 dark:text-gray-200 rounded-xl transition-colors font-medium text-[0.85rem] shadow-sm flex-shrink-0" title="Buscar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                                
                                <!-- Clear Button -->
                                @if(request()->anyFilled(['search', 'created_at_from']))
                                    <a href="{{ route('admin.incidents.index') }}" class="flex items-center justify-center px-4 py-2.5 bg-[#FFF1F2] hover:bg-[#FFE4E6] dark:bg-rose-900/20 dark:hover:bg-rose-900/40 text-[#E11D48] dark:text-rose-400 rounded-xl transition-colors font-medium text-[0.85rem] gap-1.5 shadow-sm flex-shrink-0" title="Limpiar filtros">
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
                                    Reporte
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest hidden lg:table-cell min-w-[200px]">
                                    Reportado Por
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest min-w-[150px]">
                                    Ubicación
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest min-w-[150px]">
                                    Estado
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest text-right min-w-[100px]">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70">
                            @forelse ($incidents as $incident)
                                <tr class="hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 dark:bg-[#18191A] transition-colors group">
                                    <td class="px-6 py-5 relative">
                                        <div class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100 pr-4">{{ $incident->title }}</div>
                                        <div class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-1 line-clamp-2 pr-4 leading-relaxed" title="{{ $incident->description }}">{{ $incident->description }}</div>
                                        <div class="text-[0.7rem] text-slate-400 dark:text-[#9CA3AF] mt-2 flex items-center gap-1.5 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $incident->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 hidden lg:table-cell align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-[#3A3B3C] flexitems-center justify-center text-slate-600 dark:text-gray-300 font-bold text-[0.8rem] ring-1 ring-slate-200/50 flex">
                                                <span class="m-auto">{{ substr($incident->reportedBy->name ?? '?', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-[0.85rem] font-bold text-slate-700 dark:text-gray-200">{{ $incident->reportedBy->name ?? '—' }}</div>
                                                <div class="text-[0.75rem] text-slate-400 dark:text-[#9CA3AF] mt-0.5">{{ $incident->reportedBy->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex items-start gap-2 text-[0.85rem] text-slate-600 dark:text-gray-300 font-medium">
                                            <svg class="w-4 h-4 text-slate-400 dark:text-[#9CA3AF] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="leading-tight">{{ $incident->location ?? '—' }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-5 align-top">
                                        @php
                                            $status = strtolower($incident->status);
                                            $statusClass = match($status) {
                                                'resuelto', 'cerrado' => 'bg-[#ECFDF5] text-[#059669] ring-1 ring-[#059669]/20',
                                                'en progreso' => 'bg-[#EFF6FF] text-[#2563EB] ring-1 ring-[#2563EB]/20',
                                                'asignado' => 'bg-[#F0FDF4] text-[#16A34A] ring-1 ring-[#16A34A]/20',
                                                'pendiente de revisión' => 'bg-[#FFFBEB] text-[#D97706] ring-1 ring-[#D97706]/20',
                                                default => 'bg-[#F1F5F9] text-[#475569] ring-1 ring-[#475569]/20'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[0.75rem] font-bold uppercase tracking-wider {{ $statusClass }}">
                                            {{ $incident->status }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-5 text-right align-top">
                                        <div class="flex items-center justify-end gap-1.5 text-slate-400 dark:text-[#9CA3AF] opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.incidents.show', $incident->id) }}" class="p-2 hover:bg-slate-100 dark:bg-[#3A3B3C] hover:text-slate-700 dark:text-gray-200 rounded-lg transition-colors" title="Ver detalle">
                                                <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center text-slate-500 dark:text-[#B0B3B8]">
                                        <div class="flex items-center justify-center flex-col">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            <span class="font-medium text-slate-600 dark:text-gray-300">No se encontraron incidentes.</span>
                                            @if(request()->anyFilled(['search', 'created_at_from']))
                                                <a href="{{ route('admin.incidents.index') }}" class="mt-3 text-[#E11D48] hover:text-[#BE123C] font-semibold text-sm">Limpiar filtros</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                @if ($incidents->hasPages() || $incidents->total() > 0)
                <div class="px-6 py-5 border-t border-slate-100 dark:border-[#3A3B3C] flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto style-pagination-none">
                    <div class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] font-medium whitespace-nowrap">
                        Mostrando <span class="font-bold text-slate-700 dark:text-gray-200">{{ $incidents->firstItem() ?? 0 }}</span> a <span class="font-bold text-slate-700 dark:text-gray-200">{{ $incidents->lastItem() ?? 0 }}</span> de <span class="font-bold text-slate-700 dark:text-gray-200">{{ $incidents->total() }}</span> incidentes
                    </div>
                    
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto justify-end">
                        @if ($incidents->onFirstPage())
                            <span class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        @else
                            <a href="{{ $incidents->previousPageUrl() }}" class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] hover:border-slate-300 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        @endif

                        <div class="flex items-center gap-1.5 mx-1">
                            @foreach ($incidents->getUrlRange(max(1, $incidents->currentPage() - 1), min($incidents->lastPage(), $incidents->currentPage() + 1)) as $page => $url)
                                @if ($page == $incidents->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#1A202C] text-white text-[0.85rem] font-bold shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-transparent text-slate-600 dark:text-gray-300 hover:border-slate-200 dark:border-[#3A3B3C] hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] text-[0.85rem] font-semibold transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        @if ($incidents->hasMorePages())
                            <a href="{{ $incidents->nextPageUrl() }}" class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] hover:border-slate-300 transition-colors shadow-sm">
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
