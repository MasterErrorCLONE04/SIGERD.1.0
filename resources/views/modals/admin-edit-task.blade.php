{{-- Modal para Editar Tarea --}}
<div id="editTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
            onclick="closeModal('editTaskModal')"></div>

        <!-- Modal Content -->
        <div
            class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white dark:bg-[#242526] dark:bg-gray-800 px-6 pt-6 pb-4">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 id="editTaskModalTitle"
                            class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">Editar
                            Tarea</h3>
                    </div>
                    <button onclick="closeModal('editTaskModal')"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editTaskForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Validation Errors Banner --}}
                    @if ($errors->any() && old('_method') === 'PUT')
                        <div
                            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
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

                    <div>
                        <label for="edit_task_title"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Título
                            *</label>
                        <input id="edit_task_title" name="title" type="text" required
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="edit_task_description"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea id="edit_task_description" name="description" rows="3"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_task_deadline"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Fecha
                                Límite *</label>
                            <input id="edit_task_deadline" name="deadline_at" type="date" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="edit_task_location"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Ubicación
                                *</label>
                            <input id="edit_task_location" name="location" type="text" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_task_priority"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Prioridad
                                *</label>
                            <select id="edit_task_priority" name="priority" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="edit_task_status"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Estado
                                *</label>
                            <select id="edit_task_status" name="status" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-1">Asignar
                            a</label>
                        <select id="edit_task_assigned_to" name="assigned_to"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Selecciona un trabajador</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div
                        class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <button type="button" onclick="closeModal('editTaskModal')"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">Cancelar</button>
                        <button id="editTaskSubmitBtn" type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all shadow-lg">Guardar
                            Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>