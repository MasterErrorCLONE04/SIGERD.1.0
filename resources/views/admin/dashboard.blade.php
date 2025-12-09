<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 overflow-hidden shadow-lg rounded-xl mb-8">
                <div class="p-8">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __("¡Bienvenido, Administrador!") }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Aquí tienes un resumen de la actividad de tu plataforma.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Usuarios</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">{{ $totalUsers }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Tareas</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">{{ $totalTasks }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Pending Review Incidents Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Incidentes Pendientes</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">{{ $pendingReviewIncidents }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Overdue Tasks Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Tareas Vencidas</dt>
                            </div>
                            <dd class="text-4xl font-bold text-gray-900 dark:text-gray-100 leading-none">{{ $overdueTasks }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tareas por Estado</h3>
                    <canvas id="tasksByStatusChart"></canvas>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Usuarios por Rol</h3>
                    <canvas id="usersByRoleChart"></canvas>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tareas por Prioridad</h3>
                    <canvas id="tasksByPriorityChart"></canvas>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Incidentes por Estado</h3>
                    <canvas id="incidentsByStatusChart"></canvas>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl border border-white/20 dark:border-gray-700/30 overflow-hidden shadow-lg rounded-xl">
                <div class="p-6 border-b border-white/20 dark:border-gray-700/30">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Acciones Rápidas</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Gestiona tu plataforma de forma eficiente.</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <a href="{{ route('admin.users.create') }}" class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Nuevo Usuario</span>
                        </a>
                        
                        <a href="{{ route('admin.tasks.create') }}" class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center group-hover:bg-green-500/20 transition-colors">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Nueva Tarea</span>
                        </a>
                        
                        <a href="{{ route('admin.incidents.index') }}" class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div class="w-8 h-8 bg-yellow-500/10 rounded-lg flex items-center justify-center group-hover:bg-yellow-500/20 transition-colors">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Ver Reportes</span>
                        </a>
                        
                        <a href="#" class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                            <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">Configuración</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // --- Tareas por Estado Chart (Doughnut) ---
                const tasksByStatusCtx = document.getElementById('tasksByStatusChart').getContext('2d');
                const tasksByStatusData = @json($tasksByStatus);
                const tasksByStatusLabels = Object.keys(tasksByStatusData);
                const tasksByStatusValues = Object.values(tasksByStatusData);

                new Chart(tasksByStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: tasksByStatusLabels,
                        datasets: [{
                            data: tasksByStatusValues,
                            backgroundColor: [
                                '#4299e1', // blue-500
                                '#ecc94b', // yellow-500
                                '#48bb78', // green-500
                                '#fc8181', // red-400
                                '#9f7aea', // purple-400
                                '#ed8936', // orange-400
                                '#a0aec0', // gray-400
                                '#667eea', // indigo-400
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '{{ auth()->user()->darkMode ? '#d1d5db' : '#4b5563' }}' // Tailwind gray-300 or gray-700
                                }
                            },
                            title: {
                                display: false,
                            }
                        }
                    }
                });

                // --- Usuarios por Rol Chart (Bar) ---
                const usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
                const usersByRoleLabels = ['Administradores', 'Trabajadores', 'Instructores'];
                const usersByRoleValues = [{{ $adminUsers }}, {{ $workerUsers }}, {{ $instructorUsers }}];

                new Chart(usersByRoleCtx, {
                    type: 'bar',
                    data: {
                        labels: usersByRoleLabels,
                        datasets: [{
                            label: 'Número de Usuarios',
                            data: usersByRoleValues,
                            backgroundColor: [
                                '#667eea', // indigo-400
                                '#48bb78', // green-500
                                '#ecc94b', // yellow-500
                            ],
                            borderColor: [
                                '#5a67d8', // indigo-500
                                '#38a169', // green-600
                                '#d69e2e', // yellow-600
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            title: {
                                display: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '{{ auth()->user()->darkMode ? '#d1d5db' : '#4b5563' }}' // Tailwind gray-300 or gray-700
                                }
                            },
                            x: {
                                ticks: {
                                    color: '{{ auth()->user()->darkMode ? '#d1d5db' : '#4b5563' }}' // Tailwind gray-300 or gray-700
                                }
                            }
                        }
                    }
                });

                // --- Tareas por Prioridad Chart (Pie) ---
                const tasksByPriorityCtx = document.getElementById('tasksByPriorityChart').getContext('2d');
                const tasksByPriorityData = @json($tasksByPriority);
                const tasksByPriorityLabels = Object.keys(tasksByPriorityData);
                const tasksByPriorityValues = Object.values(tasksByPriorityData);

                new Chart(tasksByPriorityCtx, {
                    type: 'pie',
                    data: {
                        labels: tasksByPriorityLabels,
                        datasets: [{
                            data: tasksByPriorityValues,
                            backgroundColor: [
                                '#fc8181', // red-400 (Alta)
                                '#ecc94b', // yellow-500 (Media)
                                '#48bb78', // green-500 (Baja)
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '{{ auth()->user()->darkMode ? '#d1d5db' : '#4b5563' }}'
                                }
                            },
                            title: {
                                display: false,
                            }
                        }
                    }
                });

                // --- Incidentes por Estado Chart (Doughnut) ---
                const incidentsByStatusCtx = document.getElementById('incidentsByStatusChart').getContext('2d');
                const incidentsByStatusData = @json($incidentsByStatus);
                const incidentsByStatusLabels = Object.keys(incidentsByStatusData);
                const incidentsByStatusValues = Object.values(incidentsByStatusData);

                new Chart(incidentsByStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: incidentsByStatusLabels,
                        datasets: [{
                            data: incidentsByStatusValues,
                            backgroundColor: [
                                '#a0aec0', // gray-400 (pendiente de revisión)
                                '#667eea', // indigo-400 (asignado)
                                '#4299e1', // blue-500 (otros estados)
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '{{ auth()->user()->darkMode ? '#d1d5db' : '#4b5563' }}'
                                }
                            },
                            title: {
                                display: false,
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
