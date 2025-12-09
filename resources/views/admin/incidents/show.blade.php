<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Detalles del Reporte') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30 overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 space-y-4">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Información del Incidente</h3>
                        <p><strong class="text-gray-700 dark:text-gray-300">Título:</strong> {{ $incident->title }}</p>
                        <p><strong class="text-gray-700 dark:text-gray-300">Descripción:</strong> {{ $incident->description }}</p>
                        <p><strong class="text-gray-700 dark:text-gray-300">Ubicación:</strong> {{ $incident->location }}</p>
                        <p><strong class="text-gray-700 dark:text-gray-300">Fecha de Reporte:</strong> {{ $incident->report_date->format('d/m/Y') }}</p>
                        <p><strong class="text-gray-700 dark:text-gray-300">Estado:</strong> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">{{ ucfirst($incident->status) }}</span></p>
                        <p><strong class="text-gray-700 dark:text-gray-300">Reportado por:</strong> {{ $incident->reportedBy->name }}</p>

                        @if ($incident->initial_evidence_images && count($incident->initial_evidence_images) > 0)
                            <div class="mt-4">
                                <p class="text-lg font-semibold">Imágenes de Evidencia Inicial:</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
                                    @foreach ($incident->initial_evidence_images as $imagePath)
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Inicial" class="w-full h-32 object-cover rounded-lg shadow-md">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($incident->status === 'pendiente de revisión')
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Convertir a Tarea</h3>
                        <form method="POST" action="{{ route('admin.incidents.convert-to-task', $incident->id) }}" class="space-y-4">
                            @csrf

                            <!-- Title -->
                            <div>
                                <x-input-label for="task_title" :value="__('Título de la Tarea')" class="text-gray-700 dark:text-gray-200" />
                                <x-text-input id="task_title" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" type="text" name="task_title" :value="old('task_title', 'Incidente: ' . $incident->title)" required />
                                <x-input-error :messages="$errors->get('task_title')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="task_description" :value="__('Descripción del Trabajo a Realizar')" class="text-gray-700 dark:text-gray-200" />
                                <textarea id="task_description" name="task_description" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>{{ old('task_description', $incident->description) }}</textarea>
                                <x-input-error :messages="$errors->get('task_description')" class="mt-2" />
                            </div>

                            <!-- Assigned To -->
                            <div>
                                <x-input-label for="assigned_to" :value="__('Asignar a')" class="text-gray-700 dark:text-gray-200" />
                                <select id="assigned_to" name="assigned_to" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                    <option value="">Selecciona un trabajador</option>
                                    @foreach ($workers as $worker)
                                        <option value="{{ $worker->id }}" {{ old('assigned_to') == $worker->id ? 'selected' : '' }}>{{ $worker->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                            </div>

                            <!-- Priority -->
                            <div>
                                <x-input-label for="priority" :value="__('Prioridad')" class="text-gray-700 dark:text-gray-200" />
                                <select id="priority" name="priority" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}" {{ old('priority') == $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>

                            <!-- Deadline At -->
                            <div>
                                <x-input-label for="deadline_at" :value="__('Fecha Límite')" class="text-gray-700 dark:text-gray-200" />
                                <x-text-input id="deadline_at" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" type="date" name="deadline_at" :value="old('deadline_at')" required />
                                <x-input-error :messages="$errors->get('deadline_at')" class="mt-2" />
                            </div>

                            <!-- Location (pre-filled from incident) -->
                            <div>
                                <x-input-label for="location" :value="__('Ubicación de la Tarea')" class="text-gray-700 dark:text-gray-200" />
                                <x-text-input id="location" class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" type="text" name="location" :value="old('location', $incident->location)" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    {{ __('Convertir a Tarea') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @else
                        <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-inner">
                            <p class="text-gray-700 dark:text-gray-300"><strong class="font-medium">Nota:</strong> Este reporte ya ha sido gestionado y su estado actual es <span class="font-semibold">"{{ ucfirst($incident->status) }}"</span>.</p>
                        </div>
                    @endif

                    <div class="flex justify-start mt-6">
                        <a href="{{ route('admin.incidents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Volver a la lista de incidentes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
