<x-app-layout>
    {{-- 1. Header ----------------------------------------------------}}


    {{-- 2. Contenido -------------------------------------------------}}
    <div class="h-full p-6 lg:p-8">
        <div class="max-w-full mx-auto space-y-8 h-full flex flex-col">

            {{-- Header de la Página --}}
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center space-x-5">
                        <div class="relative group">
                            <div
                                class="absolute -inset-1 bg-gradient-to-tr from-rose-600 to-orange-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300">
                            </div>
                            <div
                                class="relative p-4 bg-gradient-to-br from-rose-500 to-orange-600 rounded-2xl shadow-xl transform group-hover:scale-105 transition-all duration-300 border border-white/20">
                                <svg class="w-8 h-8 text-white drop-shadow-sm" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Registro de Incidentes</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Monitoreo y seguimiento de reportes en tiempo real
                            </p>
                        </div>
                    </div>

                    {{-- Botón de reporte directo --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="openModal('createIncidentModal')"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white
                                bg-gradient-to-r from-rose-600 to-orange-600 hover:from-rose-700 hover:to-orange-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500
                                dark:focus:ring-offset-gray-900 shadow-lg hover:shadow-xl
                                transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Reportar Nueva Falla
                        </button>
                    </div>
                </div>
            </div>

            {{-- 2.1 Filtros + crear ------------------------------------}}
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl
                    rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30
                    px-6 py-4 space-y-4">
                <form method="GET" action="{{ route('admin.incidents.index') }}" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                        {{-- Buscador --}}
                        <div class="relative flex-1">
                            <input type="text" name="search"
                                placeholder="Buscar por título, descripción, ubicación o reportado por..."
                                value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-900
                                      border-gray-300 dark:border-gray-600
                                      text-gray-800 dark:text-gray-200
                                      focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400
                                      focus:border-rose-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="absolute left-4 top-3.5">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('admin.incidents.index', array_filter(request()->except('search'))) }}"
                                    class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    title="Limpiar búsqueda">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        {{-- Filtro fecha de creación --}}
                        <div class="w-full lg:w-48">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de
                                Creación</label>
                            <input type="date" name="created_at_from" value="{{ request('created_at_from') }}" class="w-full rounded-lg bg-gray-50 dark:bg-gray-900
                                      border-gray-300 dark:border-gray-600
                                      text-gray-800 dark:text-gray-200
                                      focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400
                                      focus:border-rose-400 transition-all duration-200 shadow-sm">
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-white
                                       bg-rose-500 hover:bg-rose-600 dark:bg-rose-600 dark:hover:bg-rose-700
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500
                                       dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </button>
                            @if(request()->anyFilled(['search', 'created_at_from']))
                                <a href="{{ route('admin.incidents.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-gray-700 dark:text-gray-300
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
                            @if(request()->anyFilled(['search', 'created_at_from']))
                                Se encontraron <strong
                                    class="text-gray-900 dark:text-white">{{ $incidents->total() }}</strong> resultado(s)
                            @else
                                Total de incidentes: <strong
                                    class="text-gray-900 dark:text-white">{{ $incidents->total() }}</strong>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2.2 Tabla ---------------------------------------------}}
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl
                    rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30
                    overflow-hidden flex-1 flex flex-col">
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Título</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Descripción</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Ubicación</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Reportado por</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Fecha de Reporte</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($incidents as $incident)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $incident->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                        {{ Str::limit($incident->description, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $incident->location ?? '—' }}</span>
                                        </div>
                                    </td>

                                    {{-- Estado con badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pendiente de revisión' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                                'asignado' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                                'en progreso' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300',
                                                'resuelto' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                                'cerrado' => 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300',
                                            ];
                                            $color = $statusColors[strtolower($incident->status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ ucfirst($incident->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($incident->reportedBy->name ?? '—', 0, 1) }}
                                            </div>
                                            <span>{{ $incident->reportedBy->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $incident->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.incidents.show', $incident->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                                  bg-rose-50 dark:bg-rose-500/20 text-rose-700 dark:text-rose-300
                                                  hover:bg-rose-100 dark:hover:bg-rose-500/30 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver Detalle
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
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            @if(request()->anyFilled(['search', 'created_at_from']))
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No se
                                                    encontraron resultados</h3>
                                                <p class="text-gray-600 dark:text-gray-400 mb-4">No hay incidentes que coincidan
                                                    con los filtros aplicados.</p>
                                                <a href="{{ route('admin.incidents.index') }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white bg-rose-500 hover:bg-rose-600 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Limpiar filtros
                                                </a>
                                            @else
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No hay
                                                    incidentes registrados</h3>
                                                <p class="text-gray-600 dark:text-gray-400">Los incidentes reportados aparecerán
                                                    aquí.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación Estilizada --}}
                @if ($incidents->hasPages() || $incidents->total() > 0)
                    <div class="px-6 py-5 bg-gray-50/50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6 mt-auto">
                        <div class="text-sm font-medium order-2 sm:order-1 flex items-center gap-2">
                            <span class="text-slate-400 dark:text-gray-500">Mostrando</span>
                            <div class="flex items-center gap-1 bg-white dark:bg-gray-800 px-2 py-1 rounded-md border border-slate-200 dark:border-gray-700 shadow-sm">
                                <span class="text-slate-900 dark:text-white font-bold">{{ $incidents->firstItem() ?? 0 }}</span>
                                <span class="text-slate-400">-</span>
                                <span class="text-slate-900 dark:text-white font-bold">{{ $incidents->lastItem() ?? 0 }}</span>
                            </div>
                            <span class="text-slate-400 dark:text-gray-500">de <span class="text-slate-700 dark:text-gray-300">{{ $incidents->total() }}</span> incidentes</span>
                        </div>

                        <div class="flex items-center gap-2 order-1 sm:order-2">
                            {{-- Botón Anterior --}}
                            @if ($incidents->onFirstPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-100 dark:border-gray-800 bg-slate-50 dark:bg-gray-900/50 text-slate-300 dark:text-gray-700 cursor-not-allowed transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $incidents->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-700 hover:border-rose-300 dark:hover:border-rose-900 transition-all shadow-sm group">
                                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Páginas Numeradas --}}
                            <div class="hidden sm:flex items-center gap-2 mx-2">
                                @foreach ($incidents->getUrlRange(max(1, $incidents->currentPage() - 1), min($incidents->lastPage(), $incidents->currentPage() + 1)) as $page => $url)
                                    @if ($page == $incidents->currentPage())
                                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-gradient-to-br from-rose-600 to-orange-600 text-white font-bold shadow-lg shadow-rose-500/30 scale-110 z-10 transition-all">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-600 dark:text-gray-400 hover:bg-slate-50 dark:hover:bg-gray-700 hover:text-rose-600 dark:hover:text-rose-400 hover:border-rose-300 dark:hover:border-rose-900 transition-all font-medium">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Botón Siguiente --}}
                            @if ($incidents->hasMorePages())
                                <a href="{{ $incidents->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-700 hover:border-rose-300 dark:hover:border-rose-900 transition-all shadow-sm group">
                                    <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-100 dark:border-gray-800 bg-slate-50 dark:bg-gray-900/50 text-slate-300 dark:text-gray-700 cursor-not-allowed transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>