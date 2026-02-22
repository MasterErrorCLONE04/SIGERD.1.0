<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Configuración
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8"
                x-data="{ activeTab: window.location.hash ? window.location.hash.slice(1) || 'notifications' : 'notifications' }"
                @hashchange.window="activeTab = window.location.hash.slice(1) || 'notifications'">
                <!-- Sidebar Configuraciones -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <nav class="flex flex-col">
                            <a href="#notifications" @click="activeTab = 'notifications'"
                                :class="activeTab === 'notifications' ? 'font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-indigo-600' : 'font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white border-transparent'"
                                class="px-6 py-4 flex items-center gap-4 text-sm transition-colors border-l-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                Notificaciones
                            </a>
                            <a href="#appearance" @click="activeTab = 'appearance'"
                                :class="activeTab === 'appearance' ? 'font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-indigo-600' : 'font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white border-transparent'"
                                class="px-6 py-4 flex items-center gap-4 text-sm transition-colors border-l-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                                    </path>
                                </svg>
                                Apariencia
                            </a>
                            <a href="#privacy" @click="activeTab = 'privacy'"
                                :class="activeTab === 'privacy' ? 'font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-indigo-600' : 'font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white border-transparent'"
                                class="px-6 py-4 flex items-center gap-4 text-sm transition-colors border-l-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Privacidad y Seguridad
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Contenido Configuración -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Notificaciones -->
                    <div id="notifications" x-show="activeTab === 'notifications'" x-cloak
                        class="bg-white dark:bg-[#242526] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3A3B3C] overflow-hidden transition-all duration-300">
                        <div class="p-6 md:p-8 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Preferencias de Notificaciones
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Controla cómo y cuándo recibes
                                correos o alertas del sistema.</p>
                        </div>
                        <div class="p-6 md:p-8 space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Nuevas Tareas o
                                        Incidentes</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Recibir un correo cuando se
                                        te asigne un
                                        elementos.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5B4EFF]">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Actualizaciones de
                                        Estado</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Notificaciones sobre
                                        cambios en tareas que
                                        sigues.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5B4EFF]">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Alertas
                                        Promocionales</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Noticias, características y
                                        nuevos
                                        lanzamientos.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5B4EFF]">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="appearance" x-data="{
                            theme: localStorage.getItem('theme') || 'system',
                            init() {
                                // Escuchar cambios en la preferencia del SO si está en modo sistema
                                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                                    if (this.theme === 'system') {
                                        if (e.matches) {
                                            document.documentElement.classList.add('dark');
                                        } else {
                                            document.documentElement.classList.remove('dark');
                                        }
                                    }
                                });
                            },
                            updateTheme(value) {
                                this.theme = value;
                                localStorage.setItem('theme', value);
                                if (value === 'dark' || (value === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                            }
                        }" x-show="activeTab === 'appearance'" x-cloak
                        class="bg-white dark:bg-[#242526] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3A3B3C] overflow-hidden transition-all duration-300">
                        <div class="p-6 md:p-8 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Apariencia</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Personaliza cómo ves la aplicación.
                            </p>
                        </div>
                        <div class="p-6 md:p-8 space-y-6">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Tema</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <button @click="updateTheme('light')"
                                        :class="theme === 'light' ? 'border-[#5B4EFF] dark:border-indigo-400' : 'border-gray-200 dark:border-gray-700'"
                                        class="relative rounded-xl border-2 bg-white dark:bg-gray-700 p-4 text-center transition h-32 flex flex-col items-center justify-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <div
                                            class="h-8 w-4/5 rounded border border-gray-100 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Claro</span>
                                        <div x-show="theme === 'light'"
                                            class="absolute -top-2.5 -right-2.5 h-6 w-6 rounded-full bg-[#5B4EFF] dark:bg-indigo-500 text-white flex items-center justify-center border-2 border-white dark:border-gray-800 shadow-sm"
                                            x-cloak>
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                                </path>
                                            </svg>
                                        </div>
                                    </button>

                                    <button @click="updateTheme('dark')"
                                        :class="theme === 'dark' ? 'border-[#5B4EFF] dark:border-indigo-400' : 'border-gray-200 dark:border-gray-700'"
                                        class="relative rounded-xl border-2 bg-[#141A29] dark:bg-gray-900 p-4 text-center transition h-32 flex flex-col items-center justify-center gap-4 hover:opacity-90">
                                        <div
                                            class="h-8 w-4/5 rounded border border-gray-700 bg-[#1E2536] dark:bg-gray-800">
                                        </div>
                                        <span class="text-sm font-semibold text-white">Oscuro</span>
                                        <div x-show="theme === 'dark'"
                                            class="absolute -top-2.5 -right-2.5 h-6 w-6 rounded-full bg-[#5B4EFF] dark:bg-indigo-500 text-white flex items-center justify-center border-2 border-white dark:border-gray-800 shadow-sm"
                                            x-cloak>
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                                </path>
                                            </svg>
                                        </div>
                                    </button>

                                    <button @click="updateTheme('system')"
                                        :class="theme === 'system' ? 'border-[#5B4EFF] dark:border-indigo-400' : 'border-gray-200 dark:border-gray-700'"
                                        class="relative rounded-xl border-2 bg-gradient-to-r from-gray-100 to-[#141A29] dark:from-gray-700 dark:to-gray-900 p-4 text-center transition h-32 flex flex-col items-center justify-center gap-4 hover:opacity-90">
                                        <div
                                            class="h-8 w-4/5 rounded border border-gray-300 dark:border-gray-600 bg-gradient-to-r from-gray-50 to-gray-600 dark:from-gray-600 dark:to-gray-800">
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Sistema</span>
                                        <div x-show="theme === 'system'"
                                            class="absolute -top-2.5 -right-2.5 h-6 w-6 rounded-full bg-[#5B4EFF] dark:bg-indigo-500 text-white flex items-center justify-center border-2 border-white dark:border-gray-800 shadow-sm"
                                            x-cloak>
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                                </path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacidad y Seguridad -->
                    <div id="privacy" x-show="activeTab === 'privacy'" x-cloak
                        class="bg-white dark:bg-[#242526] rounded-2xl shadow-sm border border-gray-100 dark:border-[#3A3B3C] overflow-hidden transition-all duration-300">
                        <div class="p-6 md:p-8 border-b border-gray-100 dark:border-[#3A3B3C]">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Privacidad y Seguridad</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-[#B0B3B8]">Gestiona tu cuenta y seguridad de
                                acceso.</p>
                        </div>
                        <div class="p-6 md:p-8 flex flex-col items-center justify-center text-center py-12">
                            <div
                                class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Sección en Construcción
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-[#B0B3B8] max-w-sm">
                                Sus configuraciones detalladas de autenticación de dos factores y gestión de
                                dispositivos llegarán próximamente.
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button
                            class="px-8 py-3 bg-[#5B4EFF] hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all">
                            Guardar Cambios
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>