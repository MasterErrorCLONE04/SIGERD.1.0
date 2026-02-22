<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600/10 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-indigo-600">assignment</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-gray-100 tracking-tight">
                {{ __('Detalles de la Tarea') }}
            </h2>
        </div>
    </x-slot>

    {{-- Fonts and Icons for this view --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="py-8 bg-slate-50 dark:bg-[#18191A] dark:bg-gray-900 min-h-screen">
        <div class="max-w-full mx-auto px-4 sm:px-8 lg:px-12 w-full">

            <div
                class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 overflow-hidden">
                {{-- Header Section --}}
                <div class="p-8 border-b border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-gray-100 dark:text-white">
                            @if($task->incident)
                                Incidente: {{ $task->title }}
                            @else
                                {{ $task->title }}
                            @endif
                        </h1>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $statusColors = [
                                    'pendiente' => 'bg-yellow-100 text-yellow-700',
                                    'asignado' => 'bg-blue-100 text-blue-700',
                                    'en progreso' => 'bg-indigo-100 text-indigo-700',
                                    'realizada' => 'bg-purple-100 text-purple-700',
                                    'finalizada' => 'bg-green-100 text-green-700',
                                    'cancelada' => 'bg-red-100 text-red-700',
                                ];
                                $priorityColors = [
                                    'alta' => 'bg-red-100 text-red-700',
                                    'media' => 'bg-amber-100 text-amber-700',
                                    'baja' => 'bg-emerald-100 text-emerald-700',
                                ];
                                $statusColor = $statusColors[$task->status] ?? 'bg-slate-100 dark:bg-[#3A3B3C] text-slate-700 dark:text-gray-200';
                                $priorityColor = $priorityColors[$task->priority] ?? 'bg-slate-100 dark:bg-[#3A3B3C] text-slate-700 dark:text-gray-200';

                                $statusDotColors = [
                                    'pendiente' => 'bg-yellow-500',
                                    'asignado' => 'bg-blue-500',
                                    'en progreso' => 'bg-indigo-500',
                                    'realizada' => 'bg-purple-500',
                                    'finalizada' => 'bg-green-500',
                                    'cancelada' => 'bg-red-500',
                                ];
                                $priorityDotColors = [
                                    'alta' => 'bg-red-500',
                                    'media' => 'bg-amber-500',
                                    'baja' => 'bg-emerald-500',
                                ];
                                $statusDot = $statusDotColors[$task->status] ?? 'bg-slate-500';
                                $priorityDot = $priorityDotColors[$task->priority] ?? 'bg-slate-500';
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }} mr-2"></span>
                                {{ ucfirst($task->status) }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $priorityColor }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $priorityDot }} mr-2"></span> Prioridad
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 text-slate-600 dark:text-gray-300 dark:text-gray-400">
                        <span class="material-symbols-outlined text-indigo-600 text-xl mt-0.5">description</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-slate-800 dark:text-gray-100 dark:text-gray-200 mb-1">Descripción</h3>
                            <p class="text-sm leading-relaxed">{{ $task->description ?: 'Sin descripción detallada.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Metadata Grid --}}
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-8 bg-slate-50/50 dark:bg-[#18191A] dark:bg-gray-900/50">
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">place</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Ubicación</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">{{ $task->location }}</p>
                    </div>
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">event</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Fecha Límite</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">
                            {{ $task->deadline_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">person</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Asignado a</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">
                            {{ $task->assignedTo->name ?? 'Sin asignar' }}
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Creado por</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">{{ $task->createdBy->name ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                {{-- Related Incident Banner --}}
                @if($task->incident)
                    <div class="px-8 py-6">
                        <div
                            class="bg-indigo-600/5 border border-indigo-600/20 rounded-xl p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-indigo-600/20 p-2 rounded-lg">
                                    <span class="material-symbols-outlined text-indigo-600 text-xl">report_problem</span>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-600/70 font-semibold uppercase tracking-wider">Incidente
                                        Relacionado</p>
                                    <p class="font-medium text-indigo-600">{{ $task->incident->title }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.incidents.show', $task->incident->id) }}"
                                class="text-indigo-600 hover:bg-indigo-600/10 px-4 py-2 rounded-lg transition-colors text-sm font-semibold">
                                Ver Incidente
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Image Galleries Section --}}
                <div
                    class="p-8 border-t border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 bg-white dark:bg-[#242526] dark:bg-gray-800 text-slate-800 dark:text-gray-100 dark:text-white">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Reference Images --}}
                        <section class="space-y-4">
                            <div
                                class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                                <div class="flex items-center space-x-2">
                                    <span class="material-symbols-outlined text-indigo-600">image</span>
                                    <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Imágenes de Referencia</h3>
                                </div>
                            </div>

                            @php $refCount = count($task->reference_images ?? []); @endphp
                            <div x-data="{ 
                                    scrollLeft() { this.$refs.grid.scrollBy({ left: -200, behavior: 'smooth' }) },
                                    scrollRight() { this.$refs.grid.scrollBy({ left: 200, behavior: 'smooth' }) }
                                 }" class="relative group">
                                <div x-ref="grid"
                                    class="flex gap-3 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-2">
                                    @if($refCount > 0)
                                        @foreach ($task->reference_images as $imagePath)
                                            <div class="w-48 h-48 flex-shrink-0 relative group/item overflow-hidden rounded-xl bg-slate-100 dark:bg-[#3A3B3C] dark:bg-gray-700 cursor-pointer border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-600 snap-start"
                                                onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')">
                                                <img alt="Ref"
                                                    class="w-full h-full object-cover transition-transform duration-300 group-hover/item:scale-110"
                                                    src="{{ asset('storage/' . $imagePath) }}" />
                                                <div
                                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover/item:opacity-100 transition-opacity flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-white">zoom_in</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @if($refCount > 3)
                                    <button @click="scrollLeft()"
                                        class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-[#242526] dark:bg-gray-800 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 shadow-lg flex items-center justify-center text-slate-600 dark:text-gray-300 dark:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                                    </button>
                                    <button @click="scrollRight()"
                                        class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-[#242526] dark:bg-gray-800 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 shadow-lg flex items-center justify-center text-slate-600 dark:text-gray-300 dark:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </button>
                                @endif
                            </div>
                        </section>

                        {{-- Initial Evidence --}}
                        <section class="space-y-4">
                            <div
                                class="flex items-center space-x-2 pb-2 border-b border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                                <span class="material-symbols-outlined text-blue-500">pending_actions</span>
                                <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Evidencia Inicial</h3>
                            </div>

                            @php $initialCount = count($task->initial_evidence_images ?? []); @endphp
                            <div x-data="{ 
                                    scrollLeft() { this.$refs.grid.scrollBy({ left: -200, behavior: 'smooth' }) },
                                    scrollRight() { this.$refs.grid.scrollBy({ left: 200, behavior: 'smooth' }) }
                                 }" class="relative group">
                                <div x-ref="grid"
                                    class="flex gap-3 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-2">
                                    @if($initialCount > 0)
                                        @foreach ($task->initial_evidence_images as $imagePath)
                                            <div class="w-48 h-48 flex-shrink-0 relative group/item rounded-xl overflow-hidden border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 cursor-pointer snap-start"
                                                onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')">
                                                <img alt="Initial"
                                                    class="w-full h-full object-cover transition-transform duration-300 group-hover/item:scale-110"
                                                    src="{{ asset('storage/' . $imagePath) }}" />
                                                <div
                                                    class="absolute top-2 left-2 bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">
                                                    INICIAL</div>
                                                <div
                                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover/item:opacity-100 transition-opacity flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-white">visibility</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div
                                            class="w-48 h-48 flex-shrink-0 bg-slate-50 dark:bg-[#18191A] dark:bg-gray-900/50 rounded-xl border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 flex items-center justify-center italic text-slate-400 dark:text-[#9CA3AF] text-xs snap-start">
                                            Sin registros iniciales</div>
                                    @endif
                                </div>
                                @if($initialCount > 3)
                                    <button @click="scrollLeft()"
                                        class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-[#242526] dark:bg-gray-800 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 shadow-lg flex items-center justify-center text-slate-600 dark:text-gray-300 dark:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                                    </button>
                                    <button @click="scrollRight()"
                                        class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-[#242526] dark:bg-gray-800 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 shadow-lg flex items-center justify-center text-slate-600 dark:text-gray-300 dark:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </button>
                                @endif
                            </div>
                        </section>

                        {{-- Final Evidence --}}
                        <section class="space-y-4">
                            <div
                                class="flex items-center space-x-2 pb-2 border-b border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                                <span class="material-symbols-outlined text-green-500">task_alt</span>
                                <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Evidencia Final</h3>
                            </div>

                            @php $finalCount = count($task->final_evidence_images ?? []); @endphp
                            <div x-data="{ 
                                    scrollLeft() { this.$refs.grid.scrollBy({ left: -200, behavior: 'smooth' }) },
                                    scrollRight() { this.$refs.grid.scrollBy({ left: 200, behavior: 'smooth' }) }
                                 }" class="relative group">
                                <div x-ref="grid"
                                    class="flex gap-3 overflow-x-auto snap-x snap-mandatory hide-scrollbar pb-2">
                                    @if($finalCount > 0)
                                        @foreach ($task->final_evidence_images as $imagePath)
                                            <div class="w-48 h-48 flex-shrink-0 relative group/item rounded-xl overflow-hidden border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 cursor-pointer snap-start"
                                                onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')">
                                                <img alt="Final"
                                                    class="w-full h-full object-cover transition-transform duration-300 group-hover/item:scale-110"
                                                    src="{{ asset('storage/' . $imagePath) }}" />
                                                <div
                                                    class="absolute top-2 left-2 bg-green-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm flex items-center">
                                                    <span class="material-symbols-outlined text-[12px] mr-0.5">check</span>
                                                    FINAL
                                                </div>
                                                <div
                                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover/item:opacity-100 transition-opacity flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-white">visibility</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div
                                            class="w-48 h-48 flex-shrink-0 bg-slate-50 dark:bg-[#18191A] dark:bg-gray-900/50 rounded-xl border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 flex items-center justify-center italic text-slate-400 dark:text-[#9CA3AF] text-xs snap-start">
                                            Sin registros finales</div>
                                    @endif
                                </div>
                                @if($finalCount > 3)
                                    <button @click="scrollLeft()"
                                        class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-[#242526] dark:bg-gray-800 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 shadow-lg flex items-center justify-center text-slate-600 dark:text-gray-300 dark:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                                    </button>
                                    <button @click="scrollRight()"
                                        class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white dark:bg-[#242526] dark:bg-gray-800 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-700 shadow-lg flex items-center justify-center text-slate-600 dark:text-gray-300 dark:text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                                    </button>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>

                {{-- Final Description --}}
                @if($task->final_description)
                    <div class="p-8 border-t border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="material-symbols-outlined text-slate-400 dark:text-[#9CA3AF]">rate_review</span>
                            <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Descripción Final del Trabajo</h3>
                        </div>
                        <div
                            class="p-5 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/50">
                            <p class="text-green-800 dark:text-green-400 font-medium leading-relaxed">
                                {{ $task->final_description }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Review Actions --}}
                @if ($task->status === 'realizada')
                    <div class="p-8 border-t border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 bg-slate-50/20">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200 mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600">fact_check</span>
                            Revisión y Control
                        </h3>
                        <form method="POST" action="{{ route('admin.tasks.review', $task->id) }}"
                            class="flex flex-wrap gap-4">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="action" value="approve"
                                class="flex-1 min-w-[200px] px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-200 dark:shadow-none hover:scale-[1.02] flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">check_circle</span>
                                Aprobar y Finalizar
                            </button>
                            <button type="submit" name="action" value="reject"
                                class="flex-1 min-w-[200px] px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-amber-200 dark:shadow-none hover:scale-[1.02] flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">assignment_return</span>
                                Devolver p/ Corrección
                            </button>
                            <button type="submit" name="action" value="delay"
                                class="flex-1 min-w-[200px] px-8 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-rose-200 dark:shadow-none hover:scale-[1.02] flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">history</span>
                                Marcar c/ Retraso
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Footer Buttons --}}
                <div
                    class="p-8 border-t border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 bg-slate-50/30 dark:bg-gray-900/30 flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.tasks.index') }}"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-600 bg-white dark:bg-[#242526] dark:bg-gray-700 text-slate-600 dark:text-gray-300 dark:text-gray-300 font-semibold hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] dark:hover:bg-gray-600 transition-all flex items-center justify-center space-x-2 shadow-sm">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        <span>Volver a la Lista</span>
                    </a>
                    @if(empty($task->initial_evidence_images) && empty($task->final_evidence_images))
                        <a href="{{ route('admin.tasks.edit', $task->id) }}"
                            class="w-full sm:w-auto px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:shadow-lg hover:shadow-indigo-600/30 transition-all flex items-center justify-center space-x-2">
                            <span class="material-symbols-outlined text-xl">edit</span>
                            <span>Editar Tarea</span>
                        </a>
                    @else
                        <button disabled
                            class="w-full sm:w-auto px-8 py-3 rounded-xl bg-slate-200 dark:bg-gray-700 text-slate-400 dark:text-[#9CA3AF] dark:text-gray-500 dark:text-[#B0B3B8] font-semibold cursor-not-allowed flex items-center justify-center space-x-2 border border-slate-200 dark:border-[#3A3B3C] dark:border-gray-600"
                            title="No se puede editar: Tarea con evidencia registrada">
                            <span class="material-symbols-outlined text-xl">block</span>
                            <span>Edición Bloqueada</span>
                        </button>
                    @endif
                </div>
            </div>

            <footer class="py-12 text-center text-slate-400 dark:text-[#9CA3AF] dark:text-gray-500 dark:text-[#B0B3B8] text-sm">
                © {{ date('Y') }} SIGERD - Todos los derechos reservados.
            </footer>
        </div>
    </div>

    {{-- Modal para ver imagen en grande --}}
    <div id="imageModal"
        class="fixed inset-0 bg-black/95 backdrop-blur-xl z-[100] hidden items-center justify-center p-6 overflow-hidden"
        onclick="closeImageModal()">
        <div class="relative w-full h-full flex flex-col items-center justify-center overflow-hidden"
            onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Imagen ampliada"
                class="max-w-full max-h-[75vh] rounded-[2rem] shadow-[0_0_100px_rgba(0,0,0,0.5)] object-contain transition-transform duration-300 transform scale-95 opacity-0"
                onload="this.classList.remove('scale-95', 'opacity-0'); this.classList.add('scale-100', 'opacity-100')">

            <button onclick="closeImageModal()"
                class="absolute top-4 right-4 text-white/40 hover:text-white transition-all duration-300 hover:scale-110 active:scale-90">
                <span class="material-symbols-outlined text-4xl">close</span>
            </button>

            {{-- Botón de descarga --}}
            <a id="downloadButton" href="" download
                class="mt-12 flex items-center gap-4 bg-white dark:bg-[#242526] text-indigo-900 px-10 py-4 rounded-[1.5rem] font-bold uppercase tracking-[0.2em] text-xs transition-all hover:scale-105 active:scale-95 shadow-2xl">
                <span class="material-symbols-outlined">download</span>
                Descargar Archivo
            </a>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            img.src = imageSrc;
            document.getElementById('downloadButton').href = imageSrc;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            img.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
                img.classList.remove('scale-95', 'opacity-0');
            }, 200);
        }

        // Cerrar con ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>