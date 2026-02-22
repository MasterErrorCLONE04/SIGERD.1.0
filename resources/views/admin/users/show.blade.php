<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 dark:text-gray-200 leading-tight">
                Detalles del Usuario
            </h2>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div
        class="py-8 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Información del Usuario -->
            <div class="mb-8">
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8">
                            <!-- Avatar y información básica -->
                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                <div class="relative">
                                    @if($user->hasProfilePhoto())
                                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                            class="h-32 w-32 rounded-3xl object-cover shadow-xl ring-4 ring-white/50 dark:ring-gray-700/50">
                                    @else
                                        <div
                                            class="h-32 w-32 rounded-3xl bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-4xl shadow-xl ring-4 ring-white/50 dark:ring-gray-700/50">
                                            {{ $user->initials }}
                                        </div>
                                    @endif
                                </div>

                                <div class="text-center sm:text-left">
                                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">{{ $user->name }}</h1>
                                    <p class="text-lg text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">{{ $user->email }}</p>
                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold shadow-lg
                                            @if($user->role === 'administrador') 
                                                bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-purple-500/30
                                            @elseif($user->role === 'instructor')
                                                bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-blue-500/30
                                            @elseif($user->role === 'trabajador')
                                                bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-green-500/30
                                            @else
                                                bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-gray-500/30
                                            @endif">
                                            @if($user->role === 'administrador')
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                </svg>
                                            @elseif($user->role === 'instructor')
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6">
                                                    </path>
                                                </svg>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estadísticas rápidas -->
                            <div class="flex-1 lg:ml-8">
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div
                                        class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 text-center border border-white/30 dark:border-gray-600/30">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">{{ $user->id }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">ID Usuario</div>
                                    </div>
                                    <div
                                        class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 text-center border border-white/30 dark:border-gray-600/30">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                            @if($user->role === 'trabajador')
                                                {{ $user->assignedTasks->count() }}
                                            @elseif($user->role === 'instructor')
                                                {{ $user->reportedIncidents->count() }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">
                                            @if($user->role === 'trabajador')
                                                Tareas Total
                                            @elseif($user->role === 'instructor')
                                                Incidentes
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 text-center border border-white/30 dark:border-gray-600/30">
                                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                            @if($user->role === 'trabajador')
                                                {{ $user->assignedTasks->where('status', 'completada')->count() }}
                                            @elseif($user->role === 'instructor')
                                                {{ $user->reportedIncidents->where('status', 'resuelto')->count() }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">
                                            @if($user->role === 'trabajador')
                                                Completadas
                                            @elseif($user->role === 'instructor')
                                                Resueltos
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div
                                        class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 text-center border border-white/30 dark:border-gray-600/30">
                                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                            @if($user->role === 'trabajador')
                                                {{ $user->assignedTasks->where('status', 'pendiente')->count() }}
                                            @elseif($user->role === 'instructor')
                                                {{ $user->reportedIncidents->where('status', 'abierto')->count() }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">
                                            @if($user->role === 'trabajador')
                                                Pendientes
                                            @elseif($user->role === 'instructor')
                                                Abiertos
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido específico por rol -->
            @if($user->role === 'trabajador')
                <!-- Tareas del Trabajador -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">Tareas Asignadas</h3>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">{{ $user->assignedTasks->count() }}
                                tareas en total</span>
                        </div>

                        @if($user->assignedTasks->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->assignedTasks->sortByDesc('created_at') as $task)
                                    <div
                                        class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl border border-white/30 dark:border-gray-600/30 p-6 hover:shadow-lg transition-all duration-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 dark:text-white">
                                                        {{ $task->title }}</h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                    @if($task->status === 'completada') 
                                                                        bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                                                    @elseif($task->status === 'en_progreso')
                                                                        bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                                                    @else
                                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                                                    @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                    </span>
                                                </div>

                                                <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-3">{{ $task->description }}</p>

                                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Creada: {{ $task->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                    @if($task->createdBy)
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                                </path>
                                                            </svg>
                                                            Por: {{ $task->createdBy->name }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="ml-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                                @if($task->priority === 'alta') 
                                                                    bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                                                @elseif($task->priority === 'media')
                                                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                                                @else
                                                                    bg-gray-100 text-gray-800 dark:text-gray-100 dark:bg-gray-700 dark:text-gray-300
                                                                @endif">
                                                    Prioridad {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 dark:text-white mb-2">No hay tareas asignadas</h3>
                                <p class="text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">Este trabajador no tiene tareas asignadas aún.</p>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif($user->role === 'instructor')
                <!-- Incidentes del Instructor -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.854-.833-2.624 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">Incidentes Reportados</h3>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">{{ $user->reportedIncidents->count() }}
                                incidentes en total</span>
                        </div>

                        @if($user->reportedIncidents->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->reportedIncidents->sortByDesc('created_at') as $incident)
                                    <div
                                        class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl border border-white/30 dark:border-gray-600/30 p-6 hover:shadow-lg transition-all duration-200">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 dark:text-white">
                                                        {{ $incident->title }}</h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                    @if($incident->status === 'resuelto') 
                                                                        bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                                                    @elseif($incident->status === 'en_proceso')
                                                                        bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                                                    @else
                                                                        bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                                                    @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                                    </span>
                                                </div>

                                                <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-3">{{ $incident->description }}</p>

                                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Reportado: {{ $incident->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                    @if($incident->updated_at != $incident->created_at)
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                                </path>
                                                            </svg>
                                                            Actualizado: {{ $incident->updated_at->format('d/m/Y H:i') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($incident->initial_evidence_images && count($incident->initial_evidence_images) > 0)
                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-2">Imágenes
                                                            de Evidencia:</p>
                                                        <div class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4">
                                                            @foreach ($incident->initial_evidence_images as $imagePath)
                                                                <div class="relative group cursor-pointer overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]"
                                                                    onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')"
                                                                    title="Click para ampliar">
                                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Inicial"
                                                                        class="h-48 w-full object-cover">
                                                                    <div
                                                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                    </div>
                                                                    <div class="absolute top-3 right-3">
                                                                        <span
                                                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-500 text-white shadow-lg">
                                                                            Inicial
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.854-.833-2.624 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 dark:text-white mb-2">No hay incidentes reportados
                                </h3>
                                <p class="text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">Este instructor no ha reportado incidentes aún.</p>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                <!-- Para administradores u otros roles -->
                <div
                    class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50">
                    <div class="p-8 text-center">
                        <div class="p-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl inline-block mb-4">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-2">Administrador del Sistema</h3>
                        <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 max-w-md mx-auto">
                            Los administradores tienen acceso completo al sistema y pueden gestionar todos los usuarios,
                            tareas e incidentes.
                        </p>
                        <div class="mt-6 grid grid-cols-2 gap-4 max-w-sm mx-auto">
                            <div
                                class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 border border-white/30 dark:border-gray-600/30">
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100 dark:text-white">Total</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">Control completo</div>
                            </div>
                            <div
                                class="bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 border border-white/30 dark:border-gray-600/30">
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100 dark:text-white">Global</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">Permisos</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Modal para ampliar imagen -->
    <div id="imageModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden items-center justify-center p-4"
        onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full">
            <img id="modalImage" src="" alt="Imagen ampliada" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
            <button onclick="closeImageModal()"
                class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 rounded-full p-3 transition transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a id="downloadButton" href="" download
                class="absolute bottom-4 right-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-full p-3 transition transform hover:scale-110 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </a>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('downloadButton').href = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>