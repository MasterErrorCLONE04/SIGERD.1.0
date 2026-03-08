<!-- Modal: Crear Nueva Tarea -->
<div id="createTaskModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            onclick="closeModal('createTaskModal')"></div>

        <!-- Modal Content -->
        <div
            class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-white/20 dark:border-gray-700">
            <div class="p-8">
                <!-- Header del Modal -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-[#1A202C] dark:bg-gray-700 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 !text-white !stroke-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white"
                                id="modal-title">Crear Nueva Tarea</h3>
                            <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">Completa la información
                                para crear una nueva tarea</p>
                        </div>
                    </div>
                    <button onclick="closeModal('createTaskModal')"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.tasks.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- Validation Errors Banner --}}
                    @if ($errors->any() && !old('_method') && old('title'))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Por favor corrige los
                                        siguientes errores:</h3>
                                    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-2">
                        <label for="task_title"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Título
                            *</label>
                        <input id="task_title" name="title" type="text" required value="{{ old('title') }}"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                            placeholder="Título de la tarea">
                    </div>

                    <div class="space-y-2">
                        <label for="task_description"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Descripción</label>
                        <textarea id="task_description" name="description" rows="3"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                            placeholder="Descripción de la tarea">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="task_deadline"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Fecha
                                Límite *</label>
                            <input id="task_deadline" name="deadline_at" type="date" required min="{{ date('Y-m-d') }}"
                                value="{{ old('deadline_at') }}"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label for="task_location"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Ubicación
                                *</label>
                            <input id="task_location" name="location" type="text" required value="{{ old('location') }}"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                placeholder="Ubicación de la tarea">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="task_priority"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Prioridad
                                *</label>
                            <select id="task_priority" name="priority" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}" {{ old('priority') == $priority ? 'selected' : '' }}>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="task_assigned_to"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Asignar
                                a *</label>
                            <select id="task_assigned_to" name="assigned_to" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                                <option value="">Selecciona un trabajador</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}" {{ old('assigned_to') == $worker->id ? 'selected' : '' }}>{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div
                        class="space-y-4 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-gray-50 dark:bg-[#1A202C]">
                        <label for="task_reference_images"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Imágenes
                            de
                            Referencia *</label>
                        <input id="task_reference_images" name="reference_images[]" type="file" accept="image/*"
                            multiple required
                            class="block w-full text-sm text-gray-900 dark:text-gray-100 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-white dark:bg-gray-700 focus:outline-none">
                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">Archivos permitidos:
                            PNG, JPG, GIF hasta
                            2MB cada uno.
                        </p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <button type="button" onclick="closeModal('createTaskModal')"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-xl font-semibold transition-all shadow-sm">Cancelar</button>
                        <button type="submit"
                            class="px-6 py-3 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white font-semibold rounded-xl transition-all shadow-lg transform hover:scale-105">Crear
                            Tarea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>