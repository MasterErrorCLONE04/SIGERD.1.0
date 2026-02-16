<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Panel de Administración') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 lg:p-8">
        <div class="max-w-full mx-auto">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl mb-8 overflow-hidden">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center shadow-lg ring-2 ring-white/30">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl lg:text-3xl font-bold text-white">
                                    {{ __("¡Bienvenido, ") }}{{ Auth::user()->name }}!</h3>
                                <p class="text-indigo-100 mt-1">Gestiona y supervisa todas las operaciones de SIGERD</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="openModal('createTaskModal')"
                                class="inline-flex items-center px-5 py-3 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Nueva Tarea
                            </button>
                            <button onclick="openModal('createUserModal')"
                                class="inline-flex items-center px-5 py-3 bg-white/10 backdrop-blur-lg text-white font-semibold rounded-xl hover:bg-white/20 transition border border-white/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Nuevo Usuario
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Total Users Card -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Usuarios</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">
                                {{ $totalUsers }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks Card -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Tareas</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">
                                {{ $totalTasks }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Pending Review Incidents Card -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Incidentes Pendientes
                                </dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">
                                {{ $pendingReviewIncidents }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Overdue Tasks Card -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Tareas Vencidas</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">
                                {{ $overdueTasks }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid - Mejorado con Descripciones -->
            <div class="space-y-6 mb-8">
                <!-- Chart 1: Tareas por Estado -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex flex-col lg:flex-row gap-6 items-center">
                        <!-- Gráfico -->
                        <div class="w-full lg:w-80 flex-shrink-0">
                            <canvas id="tasksByStatusChart" class="max-h-64"></canvas>
                        </div>
                        <!-- Descripción -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 flex items-center gap-2">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    Tareas por Estado
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    Este gráfico muestra la distribución actual de todas las tareas según su estado en
                                    el sistema. Te permite visualizar rápidamente cuántas tareas están asignadas, en
                                    progreso, realizadas, finalizadas o incompletas, facilitando la gestión y
                                    priorización del trabajo.
                                </p>
                            </div>
                            <!-- Stats Mini -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div
                                    class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 border border-blue-200 dark:border-blue-800">
                                    <div class="text-xs text-blue-600 dark:text-blue-400 font-medium mb-1">Asignadas
                                    </div>
                                    <div class="text-lg font-bold text-blue-700 dark:text-blue-300">
                                        {{ $tasksByStatus['asignado'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3 border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-xs text-yellow-600 dark:text-yellow-400 font-medium mb-1">En
                                        Progreso</div>
                                    <div class="text-lg font-bold text-yellow-700 dark:text-yellow-300">
                                        {{ $tasksByStatus['en progreso'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 border border-green-200 dark:border-green-800">
                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium mb-1">Finalizadas
                                    </div>
                                    <div class="text-lg font-bold text-green-700 dark:text-green-300">
                                        {{ $tasksByStatus['finalizada'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Usuarios por Rol -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex flex-col lg:flex-row gap-6 items-center">
                        <!-- Gráfico -->
                        <div class="w-full lg:w-80 flex-shrink-0">
                            <canvas id="usersByRoleChart" class="max-h-64"></canvas>
                        </div>
                        <!-- Descripción -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 flex items-center gap-2">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    Usuarios por Rol
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    Visualiza la composición de tu equipo según los roles asignados. Este gráfico te
                                    ayuda a entender la distribución de administradores, instructores y trabajadores en
                                    el sistema, permitiéndote balancear las responsabilidades y recursos del equipo.
                                </p>
                            </div>
                            <!-- Stats Mini -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div
                                    class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-3 border border-indigo-200 dark:border-indigo-800">
                                    <div class="text-xs text-indigo-600 dark:text-indigo-400 font-medium mb-1">
                                        Administradores</div>
                                    <div class="text-lg font-bold text-indigo-700 dark:text-indigo-300">
                                        {{ $usersByRole['administrador'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3 border border-purple-200 dark:border-purple-800">
                                    <div class="text-xs text-purple-600 dark:text-purple-400 font-medium mb-1">
                                        Instructores</div>
                                    <div class="text-lg font-bold text-purple-700 dark:text-purple-300">
                                        {{ $usersByRole['instructor'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-pink-50 dark:bg-pink-900/20 rounded-lg p-3 border border-pink-200 dark:border-pink-800">
                                    <div class="text-xs text-pink-600 dark:text-pink-400 font-medium mb-1">Trabajadores
                                    </div>
                                    <div class="text-lg font-bold text-pink-700 dark:text-pink-300">
                                        {{ $usersByRole['trabajador'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 3: Tareas por Prioridad -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex flex-col lg:flex-row gap-6 items-center">
                        <!-- Gráfico -->
                        <div class="w-full lg:w-80 flex-shrink-0">
                            <canvas id="tasksByPriorityChart" class="max-h-64"></canvas>
                        </div>
                        <!-- Descripción -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 flex items-center gap-2">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    Tareas por Prioridad
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    Monitorea la distribución de tareas según su nivel de urgencia. Este análisis te
                                    permite identificar si hay un exceso de tareas de alta prioridad que requieren
                                    atención inmediata, o si el trabajo está bien equilibrado entre las diferentes
                                    prioridades.
                                </p>
                            </div>
                            <!-- Stats Mini -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 rounded-lg p-3 border border-red-200 dark:border-red-800">
                                    <div class="text-xs text-red-600 dark:text-red-400 font-medium mb-1">Alta</div>
                                    <div class="text-lg font-bold text-red-700 dark:text-red-300">
                                        {{ $tasksByPriority['alta'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3 border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-xs text-yellow-600 dark:text-yellow-400 font-medium mb-1">Media
                                    </div>
                                    <div class="text-lg font-bold text-yellow-700 dark:text-yellow-300">
                                        {{ $tasksByPriority['media'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 border border-green-200 dark:border-green-800">
                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium mb-1">Baja</div>
                                    <div class="text-lg font-bold text-green-700 dark:text-green-300">
                                        {{ $tasksByPriority['baja'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 4: Incidentes por Estado -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex flex-col lg:flex-row gap-6 items-center">
                        <!-- Gráfico -->
                        <div class="w-full lg:w-80 flex-shrink-0">
                            <canvas id="incidentsByStatusChart" class="max-h-64"></canvas>
                        </div>
                        <!-- Descripción -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 flex items-center gap-2">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    Incidentes por Estado
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                    Rastrea el flujo de trabajo de los incidentes reportados. Desde los que están
                                    pendientes de revisión, pasando por los asignados, hasta los resueltos. Este gráfico
                                    te ayuda a identificar cuellos de botella y garantizar que ningún incidente quede
                                    sin atender.
                                </p>
                            </div>
                            <!-- Stats Mini -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div
                                    class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3 border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-xs text-yellow-600 dark:text-yellow-400 font-medium mb-1">
                                        Pendientes</div>
                                    <div class="text-lg font-bold text-yellow-700 dark:text-yellow-300">
                                        {{ $incidentsByStatus['pendiente de revisión'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 border border-blue-200 dark:border-blue-800">
                                    <div class="text-xs text-blue-600 dark:text-blue-400 font-medium mb-1">Asignados
                                    </div>
                                    <div class="text-lg font-bold text-blue-700 dark:text-blue-300">
                                        {{ $incidentsByStatus['asignado'] ?? 0 }}</div>
                                </div>
                                <div
                                    class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 border border-green-200 dark:border-green-800">
                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium mb-1">Resueltos
                                    </div>
                                    <div class="text-lg font-bold text-green-700 dark:text-green-300">
                                        {{ $incidentsByStatus['resuelto'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 overflow-hidden shadow-lg rounded-xl">
                <div class="p-6 border-b border-white/20 dark:border-gray-700/30">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Acciones Rápidas</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Gestiona tu plataforma de forma eficiente.
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <button onclick="openModal('createUserModal')"
                            class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div
                                class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Nuevo Usuario</span>
                        </button>

                        <button onclick="openModal('createTaskModal')"
                            class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div
                                class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center group-hover:bg-green-500/20 transition-colors">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Nueva Tarea</span>
                        </button>

                        <a href="{{ route('admin.incidents.index') }}"
                            class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div
                                class="w-8 h-8 bg-yellow-500/10 rounded-lg flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Ver Reportes</span>
                        </a>

                        <a href="#"
                            class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div
                                class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Configuración</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para Modales (deben estar disponibles inmediatamente) -->
    <script>
        // Funciones para controlar los modales
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al presionar ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal('createUserModal');
                closeModal('createTaskModal');
            }
        });

        // Preview de imagen para usuario
        function previewUserImage(input) {
            const preview = document.getElementById('userPreviewImg');
            const placeholder = document.getElementById('userInitialsPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        function updateUserInitials(name) {
            const placeholder = document.getElementById('userInitialsPlaceholder');
            const preview = document.getElementById('userPreviewImg');

            if (preview.classList.contains('hidden')) {
                if (name.trim()) {
                    const names = name.trim().split(' ');
                    let initials = '';
                    names.forEach(n => {
                        if (n) initials += n.charAt(0).toUpperCase();
                    });
                    placeholder.textContent = initials.substring(0, 2) || '?';
                } else {
                    placeholder.textContent = '?';
                }
            }
        }
    </script>

    <!-- Modal: Crear Nuevo Usuario -->
    <div id="createUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                onclick="closeModal('createUserModal')"></div>

            <!-- Modal Content -->
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Crear Nuevo Usuario</h3>
                        </div>
                        <button onclick="closeModal('createUserModal')"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf

                        <!-- Foto de perfil -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Foto de Perfil (Opcional)
                            </label>
                            <div class="flex items-center space-x-4">
                                <div id="userImagePreview"
                                    class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg overflow-hidden">
                                    <span id="userInitialsPlaceholder">?</span>
                                    <img id="userPreviewImg" class="h-full w-full object-cover hidden" alt="Preview">
                                </div>
                                <div class="flex-1">
                                    <input type="file" id="user_profile_photo" name="profile_photo" accept="image/*"
                                        class="hidden" onchange="previewUserImage(this)">
                                    <label for="user_profile_photo"
                                        class="inline-flex items-center px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Seleccionar
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre -->
                            <div>
                                <label for="user_name"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Nombre Completo *
                                </label>
                                <input id="user_name" name="name" type="text" required
                                    oninput="updateUserInitials(this.value)"
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Nombre completo">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="user_email"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Correo Electrónico *
                                </label>
                                <input id="user_email" name="email" type="email" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="usuario@ejemplo.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Contraseña -->
                            <div>
                                <label for="user_password"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Contraseña *
                                </label>
                                <input id="user_password" name="password" type="password" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="••••••••">
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <label for="user_password_confirmation"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Confirmar Contraseña *
                                </label>
                                <input id="user_password_confirmation" name="password_confirmation" type="password"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Rol -->
                        <div>
                            <label for="user_role"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Rol del Usuario *
                            </label>
                            <select id="user_role" name="role" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona un rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones -->
                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="closeModal('createUserModal')"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all shadow-lg">
                                Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Nueva Tarea -->
    <div id="createTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                onclick="closeModal('createTaskModal')"></div>

            <!-- Modal Content -->
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Crear Nueva Tarea</h3>
                        </div>
                        <button onclick="closeModal('createTaskModal')"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.tasks.store') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf

                        <!-- Título -->
                        <div>
                            <label for="task_title"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Título *
                            </label>
                            <input id="task_title" name="title" type="text" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Título de la tarea">
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="task_description"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Descripción
                            </label>
                            <textarea id="task_description" name="description" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Descripción de la tarea"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Fecha Límite -->
                            <div>
                                <label for="task_deadline"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Fecha Límite *
                                </label>
                                <input id="task_deadline" name="deadline_at" type="date" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>

                            <!-- Ubicación -->
                            <div>
                                <label for="task_location"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Ubicación *
                                </label>
                                <input id="task_location" name="location" type="text" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Ubicación de la tarea">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Prioridad -->
                            <div>
                                <label for="task_priority"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Prioridad *
                                </label>
                                <select id="task_priority" name="priority" required
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Asignar a -->
                            <div>
                                <label for="task_assigned_to"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Asignar a
                                </label>
                                <select id="task_assigned_to" name="assigned_to"
                                    class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Selecciona un trabajador</option>
                                    @foreach ($workers as $worker)
                                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Imágenes de Referencia -->
                        <div>
                            <label for="task_reference_images"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Imágenes de Referencia (Opcional)
                            </label>
                            <input id="task_reference_images" name="reference_images[]" type="file" accept="image/*"
                                multiple
                                class="block w-full text-sm text-gray-900 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB cada una.
                            </p>
                        </div>

                        <!-- Botones -->
                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="closeModal('createTaskModal')"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all shadow-lg">
                                Crear Tarea
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- Datos del servidor en formato JSON --}}
        <script id="dashboard-tasks-status-data" type="application/json">
                {!! json_encode($tasksByStatus) !!}
            </script>
        <script id="dashboard-tasks-priority-data" type="application/json">
                {!! json_encode($tasksByPriority) !!}
            </script>
        <script id="dashboard-incidents-status-data" type="application/json">
                {!! json_encode($incidentsByStatus) !!}
            </script>
        <script id="dashboard-users-data" type="application/json">
                {
                    "admin": {{ $adminUsers }},
                    "worker": {{ $workerUsers }},
                    "instructor": {{ $instructorUsers }}
                }
            </script>

        {{-- Script principal de gráficos --}}
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                // Leer datos del servidor desde los elementos JSON
                const tasksByStatusData = JSON.parse(document.getElementById('dashboard-tasks-status-data').textContent);
                const tasksByPriorityData = JSON.parse(document.getElementById('dashboard-tasks-priority-data').textContent);
                const incidentsByStatusData = JSON.parse(document.getElementById('dashboard-incidents-status-data').textContent);
                const usersData = JSON.parse(document.getElementById('dashboard-users-data').textContent);
                // Detectar modo oscuro
                const isDarkMode = document.documentElement.classList.contains('dark');
                const labelColor = isDarkMode ? '#d1d5db' : '#4b5563';
                const gridColor = isDarkMode ? '#374151' : '#e5e7eb';

                // --- Tareas por Estado Chart (Doughnut) ---
                const tasksByStatusCtx = document.getElementById('tasksByStatusChart').getContext('2d');
                const tasksByStatusLabels = Object.keys(tasksByStatusData);
                const tasksByStatusValues = Object.values(tasksByStatusData);

                const taskStatusColors = {
                    'asignado': '#4299e1', // blue-500
                    'en progreso': '#ecc94b', // yellow-500
                    'finalizada': '#48bb78', // green-500
                };

                const taskStatusBackgrounds = tasksByStatusLabels.map(label => taskStatusColors[label] || '#a0aec0');

                new Chart(tasksByStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: tasksByStatusLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            data: tasksByStatusValues,
                            backgroundColor: taskStatusBackgrounds,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: labelColor }
                            },
                            title: { display: false }
                        }
                    }
                });

                // --- Usuarios por Rol Chart (Bar) ---
                const usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
                const usersByRoleLabels = ['Administradores', 'Trabajadores', 'Instructores'];
                const usersByRoleValues = [
                    usersData.admin,
                    usersData.worker,
                    usersData.instructor
                ];

                const userRoleColors = {
                    'Administradores': '#667eea', // indigo-500
                    'Trabajadores': '#ed64a6', // pink-500
                    'Instructores': '#9f7aea', // purple-500
                };

                const userRoleBackgrounds = usersByRoleLabels.map(label => userRoleColors[label]);

                new Chart(usersByRoleCtx, {
                    type: 'bar',
                    data: {
                        labels: usersByRoleLabels,
                        datasets: [{
                            label: 'Número de Usuarios',
                            data: usersByRoleValues,
                            backgroundColor: userRoleBackgrounds,
                            borderColor: userRoleBackgrounds, // Same as background
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { color: labelColor },
                                grid: { color: gridColor }
                            },
                            x: {
                                ticks: { color: labelColor },
                                grid: { color: gridColor }
                            }
                        }
                    }
                });

                // --- Tareas por Prioridad Chart (Pie) ---
                const tasksByPriorityCtx = document.getElementById('tasksByPriorityChart').getContext('2d');
                const tasksByPriorityLabels = Object.keys(tasksByPriorityData);
                const tasksByPriorityValues = Object.values(tasksByPriorityData);

                const priorityColors = {
                    'alta': '#fc8181', // red-400
                    'media': '#ecc94b', // yellow-500
                    'baja': '#48bb78', // green-500
                };

                const priorityBackgrounds = tasksByPriorityLabels.map(label => priorityColors[label] || '#a0aec0');

                new Chart(tasksByPriorityCtx, {
                    type: 'pie',
                    data: {
                        labels: tasksByPriorityLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            data: tasksByPriorityValues,
                            backgroundColor: priorityBackgrounds,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: labelColor }
                            },
                            title: { display: false }
                        }
                    }
                });

                // --- Incidentes por Estado Chart (Doughnut) ---
                const incidentsByStatusCtx = document.getElementById('incidentsByStatusChart').getContext('2d');
                const incidentsByStatusLabels = Object.keys(incidentsByStatusData);
                const incidentsByStatusValues = Object.values(incidentsByStatusData);

                const incidentStatusColors = {
                    'pendiente de revisión': '#ecc94b', // yellow-500
                    'asignado': '#4299e1', // blue-500
                    'resuelto': '#48bb78', // green-500
                };

                const incidentStatusBackgrounds = incidentsByStatusLabels.map(label => incidentStatusColors[label] || '#a0aec0');

                new Chart(incidentsByStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: incidentsByStatusLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            data: incidentsByStatusValues,
                            backgroundColor: incidentStatusBackgrounds,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: labelColor }
                            },
                            title: { display: false }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>