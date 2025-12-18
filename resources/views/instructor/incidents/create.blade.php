<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Reportar Nueva Falla') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-rose-50 to-pink-50 dark:from-gray-900 dark:via-gray-900 dark:to-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Información del Reporte</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Completa todos los campos para reportar una nueva falla en el sistema.</p>
                    </div>

                    <form method="POST" action="{{ route('instructor.incidents.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Título del Reporte')" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">Proporciona un título descriptivo y claro para la falla</p>
                            <x-text-input id="title" 
                                          class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400" 
                                          type="text" 
                                          name="title" 
                                          :value="old('title')" 
                                          placeholder="Ej: Fuga de agua en el área de producción"
                                          required 
                                          autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Descripción Detallada del Problema')" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">Describe en detalle qué falla observaste, cuándo ocurrió y cualquier información relevante</p>
                            <textarea id="description" 
                                      name="description" 
                                      rows="5"
                                      class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:border-rose-500 dark:focus:border-rose-600 focus:ring-rose-500 dark:focus:ring-rose-600 shadow-sm" 
                                      placeholder="Describe detalladamente el problema que observaste..."
                                      required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Área o Ubicación Afectada')" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">Especifica dónde se encuentra la falla</p>
                            <x-text-input id="location" 
                                          class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400" 
                                          type="text" 
                                          name="location" 
                                          :value="old('location')" 
                                          placeholder="Ej: Área de producción, Edificio A, Piso 2"
                                          required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Report Date -->
                        <div>
                            <x-input-label for="report_date" :value="__('Fecha del Reporte')" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">Selecciona la fecha en que ocurrió o detectaste la falla</p>
                            <x-text-input id="report_date" 
                                          class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-rose-500 dark:focus:ring-rose-400" 
                                          type="date" 
                                          name="report_date" 
                                          :value="old('report_date', date('Y-m-d'))" 
                                          required 
                                          max="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('report_date')" class="mt-2" />
                        </div>

                        <!-- Initial Evidence Images -->
                        <div>
                            <x-input-label for="initial_evidence_images" :value="__('Imágenes de Evidencia')" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">Sube imágenes que muestren el estado inicial o evidencia del daño. Al menos una imagen es obligatoria.</p>
                            <input id="initial_evidence_images" 
                                   class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition" 
                                   type="file" 
                                   name="initial_evidence_images[]" 
                                   accept="image/*" 
                                   multiple 
                                   required />
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <strong>Requisitos:</strong> Puedes seleccionar múltiples imágenes. Cada imagen debe ser menor a 2MB. Formatos permitidos: JPEG, PNG, JPG, GIF.
                            </p>
                            <x-input-error :messages="$errors->get('initial_evidence_images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('initial_evidence_images.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('instructor.incidents.index') }}" 
                               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition">
                                Cancelar
                            </a>
                            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('Reportar Falla') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
