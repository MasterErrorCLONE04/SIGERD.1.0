<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-[#F4F6FF] dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-[#4F46E5] dark:text-indigo-400 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Reportar Nueva Falla') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30 overflow-hidden">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-2">Información
                            del Reporte</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">Completa todos los campos
                            para reportar una nueva falla en el sistema.</p>
                    </div>

                    <form method="POST" action="{{ route('instructor.incidents.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Título del Reporte')" />
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">
                                Proporciona un título descriptivo y claro para la falla</p>
                            <x-text-input id="title"
                                class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                type="text" name="title" :value="old('title')"
                                placeholder="Ej: Fuga de agua en el área de producción" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Descripción Detallada del Problema')" />
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Describe
                                en detalle qué falla observaste, cuándo ocurrió y cualquier información relevante</p>
                            <textarea id="description" name="description" rows="5"
                                class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                placeholder="Describe detalladamente el problema que observaste..."
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Área o Ubicación Afectada')" />
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Especifica
                                dónde se encuentra la falla</p>
                            <x-text-input id="location"
                                class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                type="text" name="location" :value="old('location')"
                                placeholder="Ej: Área de producción, Edificio A, Piso 2" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Report Date -->
                        <div>
                            <x-input-label for="report_date" :value="__('Fecha del Reporte')" />
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Selecciona
                                la fecha en que ocurrió o detectaste la falla</p>
                            <x-text-input id="report_date"
                                class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 cursor-not-allowed opacity-80"
                                type="date" name="report_date" :value="old('report_date', now('America/Bogota')->format('Y-m-d'))" required
                                min="{{ now('America/Bogota')->format('Y-m-d') }}"
                                max="{{ now('America/Bogota')->format('Y-m-d') }}" readonly />
                            <x-input-error :messages="$errors->get('report_date')" class="mt-2" />
                        </div>

                        <!-- Initial Evidence Images -->
                        <div>
                            <x-input-label for="initial_evidence_images" :value="__('Imágenes de Evidencia')" />
                            <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 mt-1 mb-2">Sube
                                imágenes que muestren el estado inicial o evidencia del daño. Al menos una imagen es
                                obligatoria.</p>
                            <input id="initial_evidence_images"
                                class="block mt-1 w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition"
                                type="file" name="initial_evidence_images[]" accept="image/*" multiple required />
                            <p class="mt-2 text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">
                                <strong>Requisitos:</strong> Puedes seleccionar múltiples imágenes. Cada imagen debe ser
                                menor a 2MB. Formatos permitidos: JPEG, PNG, JPG, GIF.
                            </p>
                            <x-input-error :messages="$errors->get('initial_evidence_images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('initial_evidence_images.*')" class="mt-2" />
                        </div>

                        <div
                            class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                            <a href="{{ route('instructor.incidents.index') }}"
                                class="px-5 py-2.5 rounded-lg text-sm font-semibold bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-[#1A202C] hover:bg-[#2D3748] text-white font-semibold rounded-lg transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 focus:outline-none">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Reportar Nueva Falla') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>