<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('worker.tasks.index') }}"
                class="p-2 text-slate-400 hover:text-indigo-600 dark:text-gray-500 dark:hover:text-indigo-400 hover:bg-slate-200/50 dark:hover:bg-[#3A3B3C] rounded-xl transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-xl font-bold text-slate-800 dark:text-gray-100 tracking-tight">
                {{ __('Detalles de Tarea') }}
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
                                    'pendiente' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'asignado' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'en progreso' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                    'realizada' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                    'finalizada' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'cancelada' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                $priorityColors = [
                                    'alta' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                    'media' => 'bg-amber-100 text-amber-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'baja' => 'bg-emerald-100 text-emerald-700 dark:bg-green-900/30 dark:text-green-400',
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
                            <h3 class="font-semibold text-slate-800 dark:text-gray-100 dark:text-gray-200 mb-1">
                                Descripción</h3>
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
                        <div
                            class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">place</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Ubicación</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">{{ $task->location }}
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div
                            class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">event</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Fecha Límite</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">
                            {{ $task->deadline_at ? $task->deadline_at->format('d/m/Y H:i') : 'No establecida' }}
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div
                            class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">engineering</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Rol</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">
                            Trabajador / Organizador
                        </p>
                    </div>
                    <div
                        class="bg-white dark:bg-[#242526] dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div
                            class="flex items-center space-x-2 text-slate-500 dark:text-[#B0B3B8] dark:text-gray-400 mb-2">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span class="text-xs font-medium uppercase tracking-wider">Asignado por</span>
                        </div>
                        <p class="font-semibold text-slate-800 dark:text-gray-100 dark:text-white">
                            {{ $task->createdBy->name ?? 'Administración' }}
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
                            <a href="#"
                                class="text-indigo-600 hover:bg-indigo-600/10 px-4 py-2 rounded-lg transition-colors text-sm font-semibold pointer-events-none opacity-50">
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
                                    <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Imágenes
                                        de Referencia</h3>
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
                                    @else
                                        <div
                                            class="w-48 h-48 flex-shrink-0 bg-slate-50 dark:bg-[#18191A] dark:bg-gray-900/50 rounded-xl border border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 flex items-center justify-center italic text-slate-400 dark:text-[#9CA3AF] text-xs snap-start">
                                            Sin referencias</div>
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
                                <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Evidencia
                                    Inicial</h3>
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
                                                    INICIAl</div>
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
                                <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Evidencia
                                    Final</h3>
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
                            <h3 class="font-bold text-slate-800 dark:text-gray-100 dark:text-gray-200">Descripción Final del
                                Trabajo</h3>
                        </div>
                        <div
                            class="p-5 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/50">
                            <p class="text-green-800 dark:text-green-400 font-medium leading-relaxed">
                                {{ $task->final_description }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Actualizar Tarea (Worker Only Section) --}}
                @if ($task->status === 'asignado' || $task->status === 'en progreso')
                    <div
                        class="p-8 border-t border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 bg-slate-50/20 dark:bg-[#18191A]">
                        <h3
                            class="text-lg font-bold text-slate-800 dark:text-gray-100 dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600">edit_square</span>
                            Actualizar Tarea
                        </h3>
                        <form method="POST" action="{{ route('worker.tasks.update', $task->id) }}"
                            enctype="multipart/form-data" x-data="{ submitting: false }"
                            x-on:submit="if (submitting) { $event.preventDefault(); return; } submitting = true;">
                            @csrf
                            @method('PUT')

                            @if ($task->status === 'asignado')
                                <!-- Initial Evidence Images -->
                                <div class="mb-6">
                                    <x-input-label for="initial_evidence_images" :value="__('Evidencia Inicial: Estado de la Falla al Llegar')" />
                                    <p class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 mt-1">
                                        Sube imágenes que muestren cómo encontraste la falla al llegar al lugar.
                                    </p>
                                    <input id="initial_evidence_images"
                                        class="block mt-1 w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 rounded-lg cursor-pointer bg-white dark:bg-[#242526] dark:text-gray-400 focus:outline-none dark:border-gray-600 p-2"
                                        type="file" name="initial_evidence_images[]" accept="image/*" multiple />
                                    <p class="mt-1 text-xs text-slate-500 dark:text-gray-400">Máximo 2MB por imagen</p>
                                    <x-input-error :messages="$errors->get('initial_evidence_images')" class="mt-2" />
                                    <x-input-error :messages="$errors->all('initial_evidence_images.*')" class="mt-2" />
                                </div>
                            @endif

                            @if ($task->status === 'en progreso')
                                <!-- Final Evidence Images -->
                                <div class="mb-6">
                                    <x-input-label for="final_evidence_images" :value="__('Evidencia Final: Trabajo Completado')" />
                                    <p class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 mt-1">
                                        Sube imágenes que muestren el trabajo finalizado documentando la reparación.
                                    </p>
                                    <input id="final_evidence_images"
                                        class="block mt-1 w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 rounded-lg cursor-pointer bg-white dark:bg-[#242526] dark:text-gray-400 focus:outline-none dark:border-gray-600 p-2"
                                        type="file" name="final_evidence_images[]" accept="image/*" multiple required />
                                    <p class="mt-1 text-xs text-slate-500 dark:text-gray-400">Máximo 2MB por imagen</p>
                                    <x-input-error :messages="$errors->get('final_evidence_images')" class="mt-2" />
                                    <x-input-error :messages="$errors->all('final_evidence_images.*')" class="mt-2" />
                                </div>

                                <!-- Final Description -->
                                <div class="mb-6">
                                    <x-input-label for="final_description" :value="__('Descripción del Trabajo Realizado')" />
                                    <textarea id="final_description" name="final_description" rows="4"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-[#242526] text-gray-700 dark:text-gray-200 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        placeholder="Describe qué acciones realizaste..."
                                        required>{{ old('final_description', $task->final_description) }}</textarea>
                                    <x-input-error :messages="$errors->get('final_description')" class="mt-2" />
                                </div>
                            @endif

                            <div class="flex items-center justify-end gap-3 mt-8">
                                <a href="{{ route('worker.tasks.index') }}"
                                    class="px-5 py-2.5 bg-[#1A202C] hover:bg-[#2D3748] text-white font-semibold rounded-lg transition-colors text-sm shadow-sm focus:ring-2 focus:ring-slate-200">
                                    Cancelar
                                </a>
                                <x-primary-button class="px-5 py-2.5 text-sm" x-bind:disabled="submitting"
                                    x-bind:class="{ 'opacity-50 cursor-not-allowed': submitting }">
                                    <span x-show="!submitting">{{ __('Enviar Evidencia') }}</span>
                                    <span x-show="submitting">{{ __('Enviando...') }}</span>
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div
                        class="p-8 border-t border-slate-100 dark:border-[#3A3B3C] dark:border-gray-700 bg-slate-50/20 dark:bg-[#18191A]">
                        <div
                            class="flex items-center gap-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800/50 rounded-lg">
                            <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">info</span>
                            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                                <strong class="font-medium">Nota:</strong> Esta tarea tiene un estado que no permite
                                actualizaciones desde tu perfil (Estado actual: <span
                                    class="font-semibold uppercase tracking-wide">"{{ $task->status }}"</span>). Contacta al
                                administrador si requiere correcciones.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Image Modal --}}
            <div id="imageModal"
                class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm z-[100] hidden items-center justify-center p-4 transition-all duration-300"
                onclick="closeImageModal()">
                <div class="relative max-w-7xl max-h-full flex items-center justify-center"
                    onclick="event.stopPropagation()">
                    <img id="modalImage" src="" alt="Ampliada"
                        class="max-w-full max-h-[90vh] rounded-xl shadow-2xl object-contain border border-white/10 ring-1 ring-white/10">

                    <button onclick="closeImageModal()"
                        class="absolute -top-4 -right-4 md:top-4 md:right-4 text-white hover:text-red-400 bg-black/50 hover:bg-black/80 rounded-full p-2.5 transition-all hover:scale-110">
                        <span class="material-symbols-outlined text-xl">close</span>
                    </button>

                    <a id="downloadButton" href="" download
                        class="absolute bottom-4 right-4 text-white bg-[#1A202C] hover:bg-[#2D3748] rounded-full p-3 transition-all hover:scale-110 shadow-lg flex items-center justify-center group/btn focus:ring-2 focus:ring-slate-200">
                        <span
                            class="material-symbols-outlined text-xl group-hover/btn:-translate-y-0.5 transition-transform">download</span>
                    </a>
                </div>
            </div>

            <script>
                function openImageModal(imageSrc) {
                    const modal = document.getElementById('imageModal');
                    const img = document.getElementById('modalImage');
                    const btn = document.getElementById('downloadButton');

                    img.src = imageSrc;
                    btn.href = imageSrc;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                }

                function closeImageModal() {
                    const modal = document.getElementById('imageModal');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = 'auto';
                }

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeImageModal();
                });
            </script>
        </div>
    </div>
</x-app-layout>