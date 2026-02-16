<x-app-layout>
    {{-- 1. Header con breadcrumbs e icono -----------------------------}}

    {{-- 2. Área de contenido ------------------------------------------}}
    <div class="h-full p-6 lg:p-8">
        <div class="max-w-full mx-auto space-y-8 h-full flex flex-col">

            {{-- Header de la Página --}}
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center space-x-5">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-tr from-indigo-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                            <div class="relative p-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-xl transform group-hover:scale-105 transition-all duration-300 border border-white/20">
                                <svg class="w-8 h-8 text-white drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Tareas</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Supervisa y organiza el flujo de trabajo del sistema
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2.1 Filtros + crear ------------------------------------}}
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl
                    rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30
                    px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <form method="GET" action="{{ route('admin.tasks.index') }}"
                    class="flex flex-col sm:flex-row gap-3 sm:gap-4 flex-1">
                    {{-- Buscador --}}
                    <input type="text" name="search" placeholder="Buscar por título..." value="{{ request('search') }}"
                        class="w-full sm:w-80 rounded-lg bg-gray-50 dark:bg-gray-900
                              border-gray-300 dark:border-gray-600
                              text-gray-800 dark:text-gray-200
                              focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                    {{-- Filtro prioridad --}}
                    <select name="priority" class="rounded-lg bg-gray-50 dark:bg-gray-900
                               border-gray-300 dark:border-gray-600
                               text-gray-800 dark:text-gray-200
                               focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                        <option value="">Todas las prioridades</option>
                        <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white
                               bg-indigo-500 hover:bg-indigo-600
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                               dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Buscar
                    </button>
                </form>
                <div class="flex gap-3">
                    <button onclick="openExportModal()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white
                               bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                               dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                    <button onclick="openModal('createTaskModal')" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white
                          bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                          dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Crear Tarea
                    </button>
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
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Título</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Descripción</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Prioridad</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Asignado a</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Creado por</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($tasks as $task)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $task->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($task->description, 50) }}
                                    </td>

                                    {{-- Prioridad con badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'alta' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300',
                                                'media' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                                'baja' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                            ];
                                            $color = $priorityColors[strtolower($task->priority)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>

                                    {{-- Estado con badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pendiente' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                'en progreso' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                                'completada' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                            ];
                                            $sc = $statusColors[strtolower($task->status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $task->assignedTo->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $task->createdBy->name ?? '—' }}
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.tasks.show', $task->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                                                  bg-blue-50 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300
                                                                  hover:bg-blue-100 dark:hover:bg-blue-500/30 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Ver
                                            </a>
                                            <button onclick="startEditTask({{ $task->id }})" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                                              bg-indigo-50 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300
                                                              hover:bg-indigo-100 dark:hover:bg-indigo-500/30 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </button>
                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar esta tarea?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md
                                                                           bg-red-50 dark:bg-red-500/20 text-red-700 dark:text-red-300
                                                                           hover:bg-red-100 dark:hover:bg-red-500/30 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

                {{-- Paginación Estilizada --}}
                @if ($tasks->hasPages() || $tasks->total() > 0)
                    <div
                        class="px-6 py-5 bg-gray-50/50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between gap-6 mt-auto">
                        <div class="text-sm font-medium order-2 sm:order-1 flex items-center gap-2">
                            <span class="text-slate-400 dark:text-gray-500">Mostrando</span>
                            <div
                                class="flex items-center gap-1 bg-white dark:bg-gray-800 px-2 py-1 rounded-md border border-slate-200 dark:border-gray-700 shadow-sm">
                                <span class="text-slate-900 dark:text-white font-bold">{{ $tasks->firstItem() ?? 0 }}</span>
                                <span class="text-slate-400">-</span>
                                <span class="text-slate-900 dark:text-white font-bold">{{ $tasks->lastItem() ?? 0 }}</span>
                            </div>
                            <span class="text-slate-400 dark:text-gray-500">de <span
                                    class="text-slate-700 dark:text-gray-300">{{ $tasks->total() }}</span> tareas</span>
                        </div>

                        <div class="flex items-center gap-2 order-1 sm:order-2">
                            {{-- Botón Anterior --}}
                            @if ($tasks->onFirstPage())
                                <span
                                    class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-100 dark:border-gray-800 bg-slate-50 dark:bg-gray-900/50 text-slate-300 dark:text-gray-700 cursor-not-allowed transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $tasks->previousPageUrl() }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-700 hover:border-indigo-300 dark:hover:border-indigo-900 transition-all shadow-sm group">
                                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Páginas Numeradas --}}
                            <div class="flex items-center gap-1.5 px-1">
                                @foreach ($tasks->getUrlRange(max(1, $tasks->currentPage() - 2), min($tasks->lastPage(), $tasks->currentPage() + 2)) as $page => $url)
                                    @if ($page == $tasks->currentPage())
                                        <span
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-600 dark:bg-indigo-500 text-white font-bold shadow-lg shadow-indigo-200 dark:shadow-indigo-900/20 scale-105 z-10">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-500 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 hover:text-indigo-600 dark:hover:text-white hover:shadow-sm transition-all font-medium">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Botón Siguiente --}}
                            @if ($tasks->hasMorePages())
                                <a href="{{ $tasks->nextPageUrl() }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-700 hover:border-indigo-300 dark:hover:border-indigo-900 transition-all shadow-sm group">
                                    <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-100 dark:border-gray-800 bg-slate-50 dark:bg-gray-900/50 text-slate-300 dark:text-gray-700 cursor-not-allowed transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
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
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Exportar Reporte PDF
                </h3>
                <button onclick="closeExportModal()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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

                <div
                    class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <p class="font-semibold mb-1">Información</p>
                            <p>Se exportarán únicamente las tareas <strong>finalizadas</strong> durante el mes y año
                                seleccionado.</p>
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

    {{-- Modal para Crear Tarea --}}
    <div id="createTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                onclick="closeModal('createTaskModal')"></div>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Crear Nueva Tarea</h3>
                        </div>
                        <button onclick="closeModal('createTaskModal')"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
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
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Título
                                *</label>
                            <input id="task_title" name="title" type="text" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Título de la tarea">
                        </div>

                        <div>
                            <label for="task_description"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea id="task_description" name="description" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Descripción de la tarea"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="task_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha
                                    Límite *</label>
                                <input id="task_deadline" name="deadline_at" type="date" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label for="task_location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Ubicación
                                    *</label>
                                <input id="task_location" name="location" type="text" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Ubicación de la tarea">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="task_priority"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Prioridad
                                    *</label>
                                <select id="task_priority" name="priority" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="task_assigned_to"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Asignar
                                    a</label>
                                <select id="task_assigned_to" name="assigned_to"
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Selecciona un trabajador</option>
                                    @foreach ($workers as $worker)
                                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="task_reference_images"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Imágenes de
                                Referencia (Opcional)</label>
                            <input id="task_reference_images" name="reference_images[]" type="file" accept="image/*"
                                multiple
                                class="block w-full text-sm text-gray-900 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB cada una.
                            </p>
                        </div>

                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="closeModal('createTaskModal')"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">Cancelar</button>
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
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <h3 id="editTaskModalTitle" class="text-xl font-bold text-gray-900 dark:text-white">Editar
                                Tarea</h3>
                        </div>
                        <button onclick="closeModal('editTaskModal')"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
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
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Título
                                *</label>
                            <input id="edit_task_title" name="title" type="text" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="edit_task_description"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea id="edit_task_description" name="description" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_task_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha
                                    Límite *</label>
                                <input id="edit_task_deadline" name="deadline_at" type="date" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="edit_task_location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Ubicación
                                    *</label>
                                <input id="edit_task_location" name="location" type="text" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_task_priority"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Prioridad
                                    *</label>
                                <select id="edit_task_priority" name="priority" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="edit_task_status"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Estado
                                    *</label>
                                <select id="edit_task_status" name="status" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Asignar
                                a</label>
                            <select id="edit_task_assigned_to" name="assigned_to"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona un trabajador</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="closeModal('editTaskModal')"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">Cancelar</button>
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