<!-- Modal: Reportar Nueva Falla -->
<div id="createIncidentModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            onclick="closeModal('createIncidentModal')"></div>

        <!-- Modal Content -->
        <div
            class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-white/20 dark:border-gray-700">
            <div class="p-8">
                <!-- Header del Modal -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-[#1A202C] dark:bg-gray-700 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 flex-shrink-0 !text-white !stroke-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white"
                                id="modal-title">Reportar Nueva Falla</h3>
                            <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">Completa todos los
                                campos
                                para reportar una nueva falla en el sistema.</p>
                        </div>
                    </div>
                    <button onclick="closeModal('createIncidentModal')" type="button"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('instructor.incidents.store') }}" enctype="multipart/form-data"
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
                        <label for="incident_title"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Título
                            del Reporte *</label>
                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">
                            Proporciona un título descriptivo y claro para la falla</p>
                        <input id="incident_title" name="title" type="text" required value="{{ old('title') }}"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                            placeholder="Ej: Fuga de agua en el área de producción">
                    </div>

                    <div class="space-y-2">
                        <label for="incident_description"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Descripción
                            Detallada del Problema *</label>
                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Describe
                            en detalle qué falla observaste, cuándo ocurrió y cualquier información relevante</p>
                        <textarea id="incident_description" name="description" rows="5" required
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                            placeholder="Describe detalladamente el problema que observaste...">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="incident_location"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Área
                                o Ubicación Afectada *</label>
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Especifica
                                dónde se encuentra la falla</p>
                            <input id="incident_location" name="location" type="text" required
                                value="{{ old('location') }}"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                placeholder="Ej: Área de producción, Edificio A, Piso 2">
                        </div>
                        <div class="space-y-2">
                            <label for="incident_report_date"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Fecha
                                del Reporte *</label>
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Selecciona
                                la fecha en que ocurrió o detectaste la falla</p>
                            <input id="incident_report_date" name="report_date" type="date" required
                                min="{{ now('America/Bogota')->format('Y-m-d') }}"
                                max="{{ now('America/Bogota')->format('Y-m-d') }}" readonly
                                value="{{ old('report_date', now('America/Bogota')->format('Y-m-d')) }}"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm cursor-not-allowed opacity-80">
                        </div>
                    </div>

                    <div
                        class="space-y-4 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-gray-50 dark:bg-[#1A202C]">
                        <label for="incident_evidence_images"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Imágenes
                            de
                            Evidencia *</label>
                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Sube
                            imágenes que muestren el estado inicial o evidencia del daño. Al menos una imagen es
                            obligatoria.</p>
                        <input id="incident_evidence_images" name="initial_evidence_images[]" type="file"
                            accept="image/*" multiple required
                            class="block w-full text-sm text-gray-900 dark:text-gray-100 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-white dark:bg-gray-700 focus:outline-none">
                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">Archivos permitidos:
                            PNG, JPG, GIF hasta
                            2MB cada uno.
                        </p>
                    </div>

                    <!-- Botones de acción -->
                    <div
                        class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <button type="button" onclick="closeModal('createIncidentModal')"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-xl font-semibold transition-all shadow-sm">Cancelar</button>
                        <button type="submit"
                            class="px-6 py-3 bg-[#1A202C] hover:bg-[#2D3748] text-white font-semibold rounded-xl transition-all shadow-lg transform hover:scale-105 inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Reportar Nueva Falla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>