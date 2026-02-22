<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Ayuda y Soporte
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Opciones Rápidas -->
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white text-center shadow-lg">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">¿Necesitas ayuda urgente?</h3>
                        <p class="text-indigo-100 text-sm mb-6">Nuestro equipo de soporte está disponible 24/7 para
                            asistirte.</p>
                        <a href="#"
                            class="inline-block w-full py-3 px-4 bg-white text-indigo-600 font-bold rounded-xl shadow hover:bg-indigo-50 transition-colors">
                            Contactar Soporte
                        </a>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-4">Manual Técnico</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Revisa la documentación completa del
                            sistema.</p>
                        <a href="#"
                            class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-2 transition-colors">
                            Descargar PDF
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- FAQs -->
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 md:p-8 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Preguntas Frecuentes
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Encuentra respuestas a los
                                problemas más comunes.</p>
                        </div>

                        <div class="p-6 md:p-8" x-data="{ expanded: 1 }">
                            <div class="space-y-4">
                                <!-- FAQ Item 1 -->
                                <div class="border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden transition-all duration-200"
                                    :class="expanded === 1 ? 'ring-2 ring-indigo-500/20 shadow-md' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                    <button @click="expanded = expanded === 1 ? null : 1"
                                        class="w-full flex items-center justify-between p-4 text-left focus:outline-none">
                                        <span class="font-semibold text-gray-900 dark:text-white">¿Cómo puedo
                                            restablecer mi contraseña?</span>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                                            :class="expanded === 1 ? 'rotate-180 text-indigo-500' : ''" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="expanded === 1" x-collapse>
                                        <div
                                            class="p-4 pt-0 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-700">
                                            Ve a la sección "Mi Perfil" en el menú desplegable superior derecho. Desde
                                            la opción "Ir a Configuración", encontrarás el apartado "Update Password"
                                            donde podrás cambiarla fácilmente introduciendo tu contraseña actual y la
                                            nueva.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 2 -->
                                <div class="border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden transition-all duration-200"
                                    :class="expanded === 2 ? 'ring-2 ring-indigo-500/20 shadow-md' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                    <button @click="expanded = expanded === 2 ? null : 2"
                                        class="w-full flex items-center justify-between p-4 text-left focus:outline-none">
                                        <span class="font-semibold text-gray-900 dark:text-white">¿Qué formato deben
                                            tener las fotos de evidencia?</span>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                                            :class="expanded === 2 ? 'rotate-180 text-indigo-500' : ''" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="expanded === 2" x-collapse style="display: none;">
                                        <div
                                            class="p-4 pt-0 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-700">
                                            Aceptamos imágenes en formato JPG, PNG o GIF. El peso máximo recomendado por
                                            cada archivo es de 2MB. Puedes subir múltiples imágenes simultáneamente al
                                            reportar un incidente o finalizar una tarea.
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 3 -->
                                <div class="border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden transition-all duration-200"
                                    :class="expanded === 3 ? 'ring-2 ring-indigo-500/20 shadow-md' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                    <button @click="expanded = expanded === 3 ? null : 3"
                                        class="w-full flex items-center justify-between p-4 text-left focus:outline-none">
                                        <span class="font-semibold text-gray-900 dark:text-white">No puedo editar un
                                            incidente que reporté, ¿por qué?</span>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                                            :class="expanded === 3 ? 'rotate-180 text-indigo-500' : ''" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="expanded === 3" x-collapse style="display: none;">
                                        <div
                                            class="p-4 pt-0 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-700">
                                            Por razones de trazabilidad, el sistema bloquea la edición de tareas e
                                            incidentes una vez que se han subido evidencias fotográficas o han comenzado
                                            a ser procesadas, esto con el fin de mantener un hilo claro de auditoría de
                                            los eventos.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>