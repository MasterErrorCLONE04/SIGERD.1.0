<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 dark:text-gray-200 leading-tight">
            {{ __('Editar Tarea') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#242526] dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.tasks.update', $task->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Título')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $task->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-[#242526] dark:bg-gray-900 text-gray-700 dark:text-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Deadline At -->
                        <div class="mt-4">
                            <x-input-label for="deadline_at" :value="__('Fecha Límite')" />
                            <x-text-input id="deadline_at" class="block mt-1 w-full" type="date" name="deadline_at" :value="old('deadline_at', $task->deadline_at ? $task->deadline_at->format('Y-m-d') : '')" required />
                            <x-input-error :messages="$errors->get('deadline_at')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Ubicación')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $task->location)" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Reference Images -->
                        @if ($task->reference_images && count($task->reference_images) > 0)
                            <div class="mt-4">
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100 dark:text-gray-200 mb-3">Imágenes de Referencia Actuales:</p>
                                <div class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4 mt-2">
                                    @foreach ($task->reference_images as $imagePath)
                                        <div class="relative group cursor-pointer overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]" onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')" title="Click para ampliar">
                                            <img src="{{ asset('storage/' . $imagePath) }}" 
                                                 alt="Imagen de Referencia" 
                                                 class="w-full h-56 object-cover">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-500 text-white shadow-lg">
                                                    Referencia
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <x-input-label for="reference_images" :value="__('Añadir/Actualizar Imágenes de Referencia (Opcional)')" />
                            <input id="reference_images" class="block mt-1 w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="reference_images[]" accept="image/*" multiple />
                            <x-input-error :messages="$errors->get('reference_images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('reference_images.*')" class="mt-2" />
                        </div>

                        <!-- Priority -->
                        <div class="mt-4">
                            <x-input-label for="priority" :value="__('Prioridad')" />
                            <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-[#242526] dark:bg-gray-900 text-gray-700 dark:text-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}" {{ old('priority', $task->priority) == $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Estado')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-[#242526] dark:bg-gray-900 text-gray-700 dark:text-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', $task->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Assigned To -->
                        <div class="mt-4">
                            <x-input-label for="assigned_to" :value="__('Asignar a')" />
                            <select id="assigned_to" name="assigned_to" class="block mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-[#242526] dark:bg-gray-900 text-gray-700 dark:text-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Selecciona un trabajador</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}" {{ old('assigned_to', $task->assigned_to) == $worker->id ? 'selected' : '' }}>{{ $worker->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Actualizar Tarea') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ampliar imagen -->
    <div id="imageModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full">
            <img id="modalImage" src="" alt="Imagen ampliada" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 rounded-full p-3 transition transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <a id="downloadButton" href="" download class="absolute bottom-4 right-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-full p-3 transition transform hover:scale-110 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </a>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('downloadButton').href = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
