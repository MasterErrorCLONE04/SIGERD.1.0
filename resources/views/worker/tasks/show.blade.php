<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Detalles de la Tarea') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Información principal de la tarea --}}
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Título y descripción --}}
                        <div class="md:col-span-2">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $task->title }}</h1>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $task->description }}</p>
                            </div>
                        </div>

                        {{-- Información básica --}}
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ubicación</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $task->location }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-red-100 dark:bg-red-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha Límite</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $task->deadline_at->format('d/m/Y') }}
                                        @if($task->deadline_at < now() && !in_array($task->status, ['finalizada', 'cancelada', 'realizada']))
                                            <span class="ml-2 text-xs text-red-600 dark:text-red-400 font-medium">(Vencida)</span>
                                        @elseif($task->deadline_at <= now()->addDays(7) && !in_array($task->status, ['finalizada', 'cancelada', 'realizada']))
                                            <span class="ml-2 text-xs text-yellow-600 dark:text-yellow-400 font-medium">(Próxima)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-100 dark:bg-purple-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Prioridad</p>
                                    @php
                                        $priorityColors = [
                                            'alta' => 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300',
                                            'media' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                            'baja' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                        ];
                                        $color = $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Estado y asignado por --}}
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Estado</p>
                                    @php
                                        $statusColors = [
                                            'asignado' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                            'en progreso' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                            'realizada' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300',
                                            'finalizada' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                            'cancelada' => 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300',
                                        ];
                                        $color = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-100 dark:bg-green-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Asignado por</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($task->createdBy->name ?? 'N/A', 0, 1) }}
                                        </div>
                                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $task->createdBy->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección de evidencias --}}
            @if ($task->reference_images && count($task->reference_images) > 0 || 
                 $task->initial_evidence_images && count($task->initial_evidence_images) > 0 || 
                 $task->final_evidence_images && count($task->final_evidence_images) > 0 ||
                 $task->final_description)
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Evidencias y Documentación</h3>
                        
                        @if ($task->reference_images && count($task->reference_images) > 0)
                            <div class="mb-8">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Imágenes de Referencia</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Imágenes de referencia proporcionadas para la tarea</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($task->reference_images as $imagePath)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Imagen de Referencia" class="w-full h-32 object-cover rounded-lg shadow-md">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank" class="opacity-0 group-hover:opacity-100 text-white">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($task->initial_evidence_images && count($task->initial_evidence_images) > 0)
                            <div class="mb-8">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Evidencia Inicial: Estado de la Falla al Llegar</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Imágenes que muestran cómo se encontró la falla al llegar al lugar</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($task->initial_evidence_images as $imagePath)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Inicial" class="w-full h-32 object-cover rounded-lg shadow-md">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank" class="opacity-0 group-hover:opacity-100 text-white">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($task->final_evidence_images && count($task->final_evidence_images) > 0)
                            <div class="mb-8">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Evidencia Final: Trabajo Completado</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Imágenes que muestran el trabajo finalizado</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach ($task->final_evidence_images as $imagePath)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Final" class="w-full h-32 object-cover rounded-lg shadow-md">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                                <a href="{{ asset('storage/' . $imagePath) }}" target="_blank" class="opacity-0 group-hover:opacity-100 text-white">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($task->final_description)
                            <div class="mb-6">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Descripción del Trabajo Realizado</p>
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $task->final_description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Formulario de actualización --}}
            @if ($task->status === 'asignado' || $task->status === 'en progreso')
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Actualizar Tarea</h3>
                        <form method="POST" action="{{ route('worker.tasks.update', $task->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($task->status === 'asignado')
                                <!-- Initial Evidence Images - Cuando llega y ve cómo encontró la falla -->
                                <div class="mb-6">
                                    <x-input-label for="initial_evidence_images" :value="__('Evidencia Inicial: Estado de la Falla al Llegar')" />
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 mt-1">
                                        Sube imágenes que muestren cómo encontraste la falla al llegar al lugar. Estas imágenes documentan el estado inicial del problema.
                                    </p>
                                    <input id="initial_evidence_images" 
                                           class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2" 
                                           type="file" 
                                           name="initial_evidence_images[]" 
                                           accept="image/*" 
                                           multiple />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Puedes seleccionar múltiples imágenes (máximo 2MB por imagen)</p>
                                    <x-input-error :messages="$errors->get('initial_evidence_images')" class="mt-2" />
                                    <x-input-error :messages="$errors->all('initial_evidence_images.*')" class="mt-2" />
                                </div>
                            @endif

                            @if ($task->status === 'en progreso')
                                <!-- Final Evidence Images - Después de haber terminado el trabajo -->
                                <div class="mb-6">
                                    <x-input-label for="final_evidence_images" :value="__('Evidencia Final: Trabajo Completado')" />
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 mt-1">
                                        Sube imágenes que muestren el trabajo finalizado. Estas imágenes documentan que el problema fue resuelto correctamente.
                                    </p>
                                    <input id="final_evidence_images" 
                                           class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-2" 
                                           type="file" 
                                           name="final_evidence_images[]" 
                                           accept="image/*" 
                                           multiple 
                                           required />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Puedes seleccionar múltiples imágenes (máximo 2MB por imagen)</p>
                                    <x-input-error :messages="$errors->get('final_evidence_images')" class="mt-2" />
                                    <x-input-error :messages="$errors->all('final_evidence_images.*')" class="mt-2" />
                                </div>

                                <!-- Final Description -->
                                <div class="mb-6">
                                    <x-input-label for="final_description" :value="__('Descripción del Trabajo Realizado')" />
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 mt-1">
                                        Describe detalladamente el trabajo que realizaste para resolver la falla.
                                    </p>
                                    <textarea id="final_description" 
                                              name="final_description" 
                                              rows="4"
                                              class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm" 
                                              placeholder="Describe qué acciones realizaste para resolver la falla..."
                                              required>{{ old('final_description', $task->final_description) }}</textarea>
                                    <x-input-error :messages="$errors->get('final_description')" class="mt-2" />
                                </div>
                            @endif

                            <div class="flex items-center justify-end gap-4 mt-6">
                                <a href="{{ route('worker.tasks.index') }}" 
                                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition">
                                    Cancelar
                                </a>
                                <x-primary-button class="px-6 py-3">
                                    {{ __('Enviar Evidencia') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                    <div class="flex items-center gap-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong class="font-medium">Nota:</strong> Esta tarea tiene un estado que no permite más actualizaciones directamente desde esta vista (Estado: <span class="font-semibold">"{{ ucfirst($task->status) }}"</span>).
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Botón volver --}}
            <div class="flex justify-start">
                <a href="{{ route('worker.tasks.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver a mis tareas
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
