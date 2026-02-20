import sys

file_path = r'c:\laragon\www\SIGERD.1.0\resources\views\admin\incidents\index.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

new_ui = """<x-app-layout>
    <div class="p-6 lg:p-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Header Card -->
            <div class="bg-white rounded-[1.25rem] shadow-sm border border-slate-200/60 p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-[#FFF1F2] rounded-2xl flex items-center justify-center text-[#E11D48] flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[1.35rem] font-bold text-slate-800 tracking-tight">Registro de Incidentes</h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Monitoreo y seguimiento de reportes en tiempo real.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col xl:flex-row items-center gap-4 w-full md:w-auto">
                        <form method="GET" action="{{ route('admin.incidents.index') }}" class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
                            <div class="relative flex-grow sm:w-80">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar por título, descripción..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200/80 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-300 transition-colors">
                                @if(request('search'))
                                    <a href="{{ route('admin.incidents.index', array_filter(request()->except('search'))) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                @endif
                            </div>
                            <div class="flex gap-2 w-full sm:w-auto">
                                <input type="date" name="created_at_from" value="{{ request('created_at_from') }}" class="w-full sm:w-auto px-4 py-2.5 bg-white border border-slate-200/80 rounded-xl text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-300 transition-colors flex-grow">
                                <button type="submit" class="sm:hidden flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </div>
                            <button type="submit" class="hidden sm:flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>

                        <div class="flex items-center gap-2 w-full xl:w-auto">
                            @if(request()->anyFilled(['search', 'created_at_from']))
                                <a href="{{ route('admin.incidents.index') }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                    Limpiar
                                </a>
                            @endif
                            <button onclick="openModal('createIncidentModal')" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-[#1A202C] hover:bg-[#2D3748] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nueva Falla
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-[1.25rem] shadow-sm border border-slate-200/60 overflow-hidden flex flex-col min-h-[500px]">
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest min-w-[300px]">
                                    Reporte
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest hidden lg:table-cell min-w-[200px]">
                                    Reportado Por
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest min-w-[150px]">
                                    Ubicación
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest min-w-[150px]">
                                    Estado
                                </th>
                                <th class="px-6 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-right min-w-[100px]">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70">
                            @forelse ($incidents as $incident)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-5 relative">
                                        <div class="text-[0.95rem] font-bold text-slate-800 pr-4">{{ $incident->title }}</div>
                                        <div class="text-[0.8rem] text-slate-500 mt-1 line-clamp-2 pr-4 leading-relaxed" title="{{ $incident->description }}">{{ $incident->description }}</div>
                                        <div class="text-[0.7rem] text-slate-400 mt-2 flex items-center gap-1.5 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $incident->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 hidden lg:table-cell align-top">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 flexitems-center justify-center text-slate-600 font-bold text-[0.8rem] ring-1 ring-slate-200/50 flex">
                                                <span class="m-auto">{{ substr($incident->reportedBy->name ?? '?', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-[0.85rem] font-bold text-slate-700">{{ $incident->reportedBy->name ?? '—' }}</div>
                                                <div class="text-[0.75rem] text-slate-400 mt-0.5">{{ $incident->reportedBy->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex items-start gap-2 text-[0.85rem] text-slate-600 font-medium">
                                            <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        <div class="flex items-center justify-end gap-1.5 text-slate-400 opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.incidents.show', $incident->id) }}" class="p-2 hover:bg-slate-100 hover:text-slate-700 rounded-lg transition-colors" title="Ver detalle">
                                                <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center text-slate-500">
                                        <div class="flex items-center justify-center flex-col">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            <span class="font-medium text-slate-600">No se encontraron incidentes.</span>
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
                <div class="px-6 py-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto style-pagination-none">
                    <div class="text-[0.85rem] text-slate-500 font-medium whitespace-nowrap">
                        Mostrando <span class="font-bold text-slate-700">{{ $incidents->firstItem() ?? 0 }}</span> a <span class="font-bold text-slate-700">{{ $incidents->lastItem() ?? 0 }}</span> de <span class="font-bold text-slate-700">{{ $incidents->total() }}</span> incidentes
                    </div>
                    
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto justify-end">
                        @if ($incidents->onFirstPage())
                            <span class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        @else
                            <a href="{{ $incidents->previousPageUrl() }}" class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        @endif

                        <div class="flex items-center gap-1.5 mx-1">
                            @foreach ($incidents->getUrlRange(max(1, $incidents->currentPage() - 1), min($incidents->lastPage(), $incidents->currentPage() + 1)) as $page => $url)
                                @if ($page == $incidents->currentPage())
                                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#1A202C] text-white text-[0.85rem] font-bold shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 text-[0.85rem] font-semibold transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        @if ($incidents->hasMorePages())
                            <a href="{{ $incidents->nextPageUrl() }}" class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
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
"""

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_ui)

print("Replacement successful")
