<!-- Modal para Editar Tarea -->
<div id="editTaskModal" class="fixed inset-0 z-[60] overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true" x-data="editTaskImages()">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            @click="closeModal('editTaskModal')"></div>

        <!-- Modal Content -->
        <div
            class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-white/20 dark:border-gray-700">
            <div class="p-8">
                <!-- Header del Modal -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 !text-white !stroke-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 id="editTaskModalTitle"
                                class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">
                                Editar Tarea
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">Actualiza la información
                                de la tarea seleccionada</p>
                        </div>
                    </div>
                    <button @click="closeModal('editTaskModal')" type="button"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editTaskForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Validation Errors Banner --}}
                    @if ($errors->any() && old('_method') === 'PUT')
                        <div
                            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-5 mb-6 shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-red-800 dark:text-red-200">Por favor corrige los
                                        siguientes errores:</h3>
                                    <ul
                                        class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1 font-medium">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-2">
                        <label for="edit_task_title"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Título
                            *</label>
                        <input id="edit_task_title" name="title" type="text" required
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                            placeholder="Título de la tarea">
                    </div>

                    <div class="space-y-2">
                        <label for="edit_task_description"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Descripción</label>
                        <textarea id="edit_task_description" name="description" rows="3"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                            placeholder="Descripción de la tarea"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="edit_task_deadline"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Fecha
                                Límite *</label>
                            <input id="edit_task_deadline" name="deadline_at" type="date" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label for="edit_task_location"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Ubicación
                                *</label>
                            <input id="edit_task_location" name="location" type="text" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                placeholder="Ubicación de la tarea">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="edit_task_priority"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Prioridad
                                *</label>
                            <select id="edit_task_priority" name="priority" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                                @foreach ($priorities ?? ['baja', 'media', 'alta', 'critica'] as $priority)
                                    <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="edit_task_status"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Estado
                                *</label>
                            <select id="edit_task_status" name="status" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
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

                    <div class="space-y-2">
                        <label for="edit_task_assigned_to"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Asignar
                            a</label>
                        <select id="edit_task_assigned_to" name="assigned_to"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                            <option value="">Selecciona un trabajador</option>
                            @if(isset($workers))
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Sección de Imágenes de Referencia -->
                    <div
                        class="space-y-4 shadow-inner border border-gray-200 dark:border-gray-700 rounded-2xl p-6 bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center justify-between">
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Imágenes de Referencia
                            </label>
                        </div>

                        <!-- Imágenes Existentes -->
                        <div x-show="existingImages.length > 0" x-cloak class="mt-3">
                            <p
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">
                                Imágenes Actuales</p>
                            <div class="flex gap-3 overflow-x-auto custom-scrollbar pb-3">
                                <template x-for="(img, index) in existingImages" :key="index">
                                    <div
                                        class="relative group/edit flex-shrink-0 w-32 h-32 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-600">
                                        <img :src="img.url" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover/edit:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" @click.prevent="openImageModal(img.url)"
                                                class="p-1.5 bg-white/20 hover:bg-white/40 rounded-full backdrop-blur-sm transition-colors"
                                                title="Ver imagen">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Subir Nuevas Imágenes -->
                        <div class="mt-4">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider"
                                x-show="existingImages.length > 0">Añadir Nuevas Imágenes</p>

                            <div class="relative group" @dragover.prevent="dragover = true"
                                @dragleave.prevent="dragover = false" @drop.prevent="handleDrop($event)">

                                <input type="file" id="edit_task_reference_images" name="reference_images[]" multiple
                                    accept="image/*" class="hidden" @change="handleFiles($event)">

                                <label for="edit_task_reference_images"
                                    class="flex flex-col items-center justify-center w-full h-32 px-4 transition-all bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl cursor-pointer hover:bg-indigo-50 dark:hover:bg-gray-700/50 hover:border-indigo-400 dark:hover:border-indigo-500 group-hover:bg-gray-50"
                                    :class="{'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-500' : dragover}">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div
                                            class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-full mb-2 text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="mb-1 text-sm text-gray-600 dark:text-gray-300 font-medium">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">Haz clic para
                                                subir</span> o arrastra y suelta
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG o GIF (Max 2MB)</p>
                                    </div>
                                </label>
                            </div>

                            <!-- Previsualización Nuevas -->
                            <div x-show="newImages.length > 0" x-cloak class="mt-4">
                                <p
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">
                                    Imágenes a Subir (<span x-text="newImages.length"></span>/10)</p>
                                <div class="flex gap-3 overflow-x-auto custom-scrollbar pb-3">
                                    <template x-for="(file, index) in newImages" :key="index">
                                        <div
                                            class="relative group/new flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-600 shadow-sm">
                                            <img :src="file.preview" class="w-full h-full object-cover">
                                            <button @click.prevent="removeFile(index)" type="button"
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-0.5 hover:bg-red-600 shadow-sm opacity-0 group-hover/new:opacity-100 transition-opacity"
                                                title="Eliminar">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            <div
                                                class="absolute bottom-0 inset-x-0 bg-black/60 text-[9px] text-white text-center py-0.5 truncate px-1">
                                                <span x-text="file.name"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div
                        class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="closeModal('editTaskModal')"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-xl font-semibold transition-all shadow-sm">
                            Cancelar
                        </button>
                        <button id="editTaskSubmitBtn" type="submit"
                            class="px-6 py-3 bg-[#1A202C] hover:bg-[#2D3748] text-white font-semibold rounded-xl transition-all shadow-lg transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5 !text-white !stroke-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('editTaskImages', () => ({
            existingImages: [],
            newImages: [],
            dragover: false,

            init() {
                // Escuchar un evento personalizado para cargar imágenes existentes cuando se abre el modal
                window.addEventListener('loadEditTaskImages', (e) => {
                    this.existingImages = e.detail.images || [];
                    this.newImages = []; // Limpiar las nuevas cuando se abre una diferente

                    // Asegurarse de limpiar el input real
                    const input = document.getElementById('edit_task_reference_images');
                    if (input) input.value = '';
                });
            },

            handleDrop(event) {
                this.dragover = false;
                const files = event.dataTransfer.files;
                if (files.length > 0) {
                    this.processFiles(files);
                }
            },

            handleFiles(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    this.processFiles(files);
                }
            },

            processFiles(files) {
                const maxFiles = 10;
                const remainingSlots = maxFiles - this.newImages.length;

                if (remainingSlots <= 0) {
                    alert('Has alcanzado el límite máximo de imágenes a subir (10).');
                    return;
                }

                const newFilesArray = Array.from(files).slice(0, remainingSlots);

                for (let file of newFilesArray) {
                    if (!file.type.match('image.*')) {
                        alert(`El archivo ${file.name} no es una imagen.`);
                        continue;
                    }

                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        alert(`El archivo ${file.name} excede el límite de 2MB.`);
                        continue;
                    }

                    // Previsualización local
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.newImages.push({
                            name: file.name,
                            file: file,
                            preview: e.target.result
                        });
                        this.updateFileInput();
                    };
                    reader.readAsDataURL(file);
                }
            },

            removeFile(index) {
                this.newImages.splice(index, 1);
                this.updateFileInput();
            },

            updateFileInput() {
                // Sincronizar el array con el input file
                const dataTransfer = new DataTransfer();
                this.newImages.forEach(img => {
                    dataTransfer.items.add(img.file);
                });
                document.getElementById('edit_task_reference_images').files = dataTransfer.files;
            }
        }));
    });
</script>