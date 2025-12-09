<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles y Actualización de Tarea') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <p class="text-lg font-semibold">Título:</p>
                        <p>{{ $task->title }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Descripción:</p>
                        <p>{{ $task->description }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Ubicación:</p>
                        <p>{{ $task->location }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Fecha Límite:</p>
                        <p>{{ $task->deadline_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Prioridad:</p>
                        <p>{{ ucfirst($task->priority) }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Estado:</p>
                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">{{ ucfirst($task->status) }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Asignado por:</p>
                        <p>{{ $task->createdBy->name ?? 'N/A' }}</p>
                    </div>

                    @if ($task->reference_images && count($task->reference_images) > 0)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Imágenes de Referencia:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
                                @foreach ($task->reference_images as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Imagen de Referencia" class="w-full h-32 object-cover rounded-lg shadow-md">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($task->initial_evidence_images && count($task->initial_evidence_images) > 0)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Imágenes de Evidencia Inicial:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
                                @foreach ($task->initial_evidence_images as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Inicial" class="w-full h-32 object-cover rounded-lg shadow-md">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($task->status === 'asignado' || $task->status === 'en progreso')
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-semibold mb-4">Actualizar Tarea</h3>
                        <form method="POST" action="{{ route('worker.tasks.update', $task->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($task->status === 'asignado')
                                <!-- Initial Evidence Images -->
                                <div class="mt-4">
                                    <x-input-label for="initial_evidence_images" :value="__('Imágenes de Evidencia Inicial')" />
                                    <input id="initial_evidence_images" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="initial_evidence_images[]" accept="image/*" multiple />
                                    <x-input-error :messages="$errors->get('initial_evidence_images')" class="mt-2" />
                                    <x-input-error :messages="$errors->all('initial_evidence_images.*')" class="mt-2" />
                                </div>
                            @endif

                            @if ($task->status === 'en progreso')
                                <!-- Final Evidence Images -->
                                <div class="mt-4">
                                    <x-input-label for="final_evidence_images" :value="__('Imágenes de Evidencia Final')" />
                                    <input id="final_evidence_images" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="final_evidence_images[]" accept="image/*" multiple required />
                                    <x-input-error :messages="$errors->get('final_evidence_images')" class="mt-2" />
                                    <x-input-error :messages="$errors->all('final_evidence_images.*')" class="mt-2" />
                                </div>

                                <!-- Final Description -->
                                <div class="mt-4">
                                    <x-input-label for="final_description" :value="__('Descripción Final del Trabajo Realizado')" />
                                    <textarea id="final_description" name="final_description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('final_description', $task->final_description) }}</textarea>
                                    <x-input-error :messages="$errors->get('final_description')" class="mt-2" />
                                </div>
                            @endif

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Enviar Evidencia') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @else
                        <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-inner">
                            <p class="text-gray-700 dark:text-gray-300"><strong class="font-medium">Nota:</strong> Esta tarea tiene un estado que no permite más actualizaciones directamente desde esta vista (Estado: <span class="font-semibold">"{{ ucfirst($task->status) }}"</span>).</p>
                        </div>
                    @endif

                    <div class="flex justify-start mt-6">
                        <a href="{{ route('worker.tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Volver a mis tareas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
