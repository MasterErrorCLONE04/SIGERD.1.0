<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 dark:text-gray-200 leading-tight">
                Detalles del Usuario
            </h2>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6 bg-slate-50 dark:bg-[#18191A] dark:bg-gray-900 min-h-screen">
        <div class="max-w-full lg:px-8 mx-auto px-4 sm:px-6">

            <!-- Información del Usuario -->
            <div class="mb-6">
                <div
                    class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C] overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8">
                            <!-- Avatar y información básica -->
                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                <div class="relative">
                                    @if($user->hasProfilePhoto())
                                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                            class="h-24 w-24 rounded-[1rem] object-cover shadow-sm ring-1 ring-slate-200 dark:ring-[#3A3B3C]">
                                    @else
                                        <div
                                            class="h-24 w-24 rounded-[1rem] bg-indigo-500 flex items-center justify-center text-white font-bold text-3xl shadow-sm">
                                            {{ $user->initials }}
                                        </div>
                                    @endif
                                </div>

                                <div class="text-center sm:text-left">
                                    <h1 class="text-2xl font-bold text-slate-800 dark:text-gray-100">
                                        {{ $user->name }}
                                    </h1>
                                    <p class="text-[0.95rem] text-slate-500 dark:text-[#B0B3B8] mt-1">
                                        {{ $user->email }}
                                    </p>
                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[0.8rem] tracking-wide font-semibold
                                            @if($user->role === 'administrador') 
                                                bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($user->role === 'instructor')
                                                bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400
                                            @elseif($user->role === 'trabajador')
                                                bg-[#10B981] text-white
                                            @else
                                                bg-slate-100 text-slate-600 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            @if($user->role === 'administrador')
                                                <svg class="w-3.5 h-3.5 mr-1.5" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @elseif($user->role === 'instructor')
                                                <svg class="w-4 h-4 mr-1.5" viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z" />
                                                    <path
                                                        d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z" />
                                                    <path
                                                        d="M4.462 19.462c.42-.419.753-.89 1-1.394.453.213.902.434 1.347.662a6.742 6.742 0 01-1.286 1.794.75.75 0 01-1.06-1.062z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 mr-1.5" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M7.5 5.25A3.25 3.25 0 0110.75 2h2.5A3.25 3.25 0 0116.5 5.25V6h3.625c.621 0 1.125.504 1.125 1.125v2.413A1.5 1.5 0 0020.25 9.6h-16.5A1.5 1.5 0 002.75 9.538V7.125C2.75 6.504 3.254 6 3.875 6H7.5v-.75zm1.5 0V6h6v-.75a1.75 1.75 0 00-1.75-1.75h-2.5A1.75 1.75 0 009 5.25z"
                                                        clip-rule="evenodd" />
                                                    <path
                                                        d="M2.75 11.25V17.5A2.25 2.25 0 005 19.75h14A2.25 2.25 0 0021 17.5v-6.25H2.75z" />
                                                </svg>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estadísticas rápidas -->
                            <div
                                class="flex-1 lg:ml-8 mt-6 lg:mt-0 lg:pl-8 lg:border-l border-slate-200 dark:border-gray-700">
                                <div
                                    class="grid grid-cols-2 lg:grid-cols-4 gap-4 items-center h-full divide-x-0 lg:divide-x divide-slate-100 dark:divide-gray-700">
                                    <div class="p-4 text-center">
                                        <div class="text-[1.35rem] mb-1 font-bold text-slate-800 dark:text-gray-100">
                                            {{ $user->id }}
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-slate-400 dark:text-[#B0B3B8] uppercase tracking-wider">
                                            ID Usuario</div>
                                    </div>
                                    <div class="p-4 text-center">
                                        <div class="text-[1.35rem] mb-1 font-bold text-blue-500 dark:text-blue-400">
                                            @if($user->role === 'trabajador')
                                                {{ $assignedTasks->total() }}
                                            @elseif($user->role === 'instructor')
                                                {{ $user->reportedIncidents->count() }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-slate-400 dark:text-[#B0B3B8] uppercase tracking-wider">
                                            @if($user->role === 'trabajador')
                                                Tareas Total
                                            @elseif($user->role === 'instructor')
                                                Incidentes
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4 text-center">
                                        <div
                                            class="text-[1.35rem] mb-1 font-bold text-emerald-500 dark:text-emerald-400">
                                            @if($user->role === 'trabajador')
                                                {{ $user->assignedTasks()->where('status', 'completada')->count() }}
                                            @elseif($user->role === 'instructor')
                                                {{ $user->reportedIncidents->where('status', 'resuelto')->count() }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-slate-400 dark:text-[#B0B3B8] uppercase tracking-wider">
                                            @if($user->role === 'trabajador')
                                                Completadas
                                            @elseif($user->role === 'instructor')
                                                Resueltos
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4 text-center">
                                        <div class="text-[1.35rem] mb-1 font-bold text-amber-500 dark:text-amber-400">
                                            @if($user->role === 'trabajador')
                                                {{ $user->assignedTasks()->where('status', 'pendiente')->count() }}
                                            @elseif($user->role === 'instructor')
                                                {{ $user->reportedIncidents->where('status', 'abierto')->count() }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div
                                            class="text-[10px] font-bold text-slate-400 dark:text-[#B0B3B8] uppercase tracking-wider">
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
                    class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C]">
                    <div class="p-6">
                        <div
                            class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-[#3A3B3C]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-[#10B981] flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-gray-100">Tareas Asignadas</h3>
                            </div>
                            <span
                                class="text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">{{ $assignedTasks->total() }}
                                tareas en total</span>
                        </div>

                        @if($assignedTasks->count() > 0)
                            <div class="space-y-4">
                                @foreach($assignedTasks as $task)
                                    <a href="{{ route('admin.tasks.show', $task->id) }}" class="block">
                                        <div
                                            class="bg-white dark:bg-[#18191A] dark:bg-gray-700 rounded-xl border border-slate-100 dark:border-[#3A3B3C] p-5 hover:border-slate-300 transition-colors">
                                            <div class="flex items-start justify-between mb-2">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3">
                                                        <h4 class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100">
                                                            {{ $task->title }}
                                                        </h4>
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                                                                    @if($task->status === 'completada') 
                                                                                        border border-emerald-200 text-emerald-600 bg-emerald-50/50 dark:border-emerald-800 dark:text-emerald-400
                                                                                    @elseif($task->status === 'en_progreso')
                                                                                        border border-blue-200 text-blue-600 bg-blue-50/50 dark:border-blue-800 dark:text-blue-400
                                                                                    @else
                                                                                        border border-amber-200 text-amber-500 bg-amber-50/30 dark:border-amber-800 dark:text-amber-400
                                                                                    @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                        </span>
                                                    </div>

                                                    <p class="text-[13px] text-slate-500 dark:text-gray-400 mt-2 mb-4 leading-relaxed line-clamp-2">
                                                        {{ $task->description }}
                                                    </p>

                                                    <div
                                                        class="flex items-center gap-4 text-[11px] font-medium text-slate-400 dark:text-[#B0B3B8]">
                                                        <div class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Creada: {{ $task->created_at->format('d/m/Y H:i') }}
                                                        </div>
                                                        @if($task->createdBy)
                                                            <div class="flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
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

                                                <div class="ml-4 flex-shrink-0">
                                                    <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider
                                                                                @if($task->priority === 'alta') 
                                                                                    text-red-500 dark:text-red-400
                                                                                @elseif($task->priority === 'media')
                                                                                    text-amber-500 dark:text-amber-400
                                                                                @else
                                                                                    text-slate-500 dark:text-slate-400
                                                                                @endif">
                                                        PRIORIDAD {{ strtoupper($task->priority) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between bg-white dark:bg-[#18191A] border border-slate-100 dark:border-[#3A3B3C] rounded-xl px-4 py-3 shadow-sm">
                                <div class="mb-4 sm:mb-0">
                                    <p class="text-[0.8rem] text-slate-500 dark:text-gray-400">
                                        Mostrando <span class="font-bold text-slate-700 dark:text-gray-200">{{ $assignedTasks->firstItem() ?? 0 }}</span> a <span class="font-bold text-slate-700 dark:text-gray-200">{{ $assignedTasks->lastItem() ?? 0 }}</span> de <span class="font-bold text-slate-700 dark:text-gray-200">{{ $assignedTasks->total() }}</span> tareas
                                    </p>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    {{-- Previous Page --}}
                                    @if ($assignedTasks->onFirstPage())
                                        <div class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-[#3A3B3C] bg-white dark:bg-[#242526] text-slate-300 dark:text-gray-600 cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </div>
                                    @else
                                        <a href="{{ $assignedTasks->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-[#3A3B3C] bg-white dark:bg-[#242526] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </a>
                                    @endif

                                    {{-- Pages (Simple Loop logic to show immediate around current) --}}
                                    @foreach(range(1, $assignedTasks->lastPage()) as $i)
                                        @if($i >= $assignedTasks->currentPage() - 2 && $i <= $assignedTasks->currentPage() + 2)
                                            @if ($i == $assignedTasks->currentPage())
                                                <div class="w-8 h-8 flex items-center justify-center rounded bg-[#1A202C] dark:bg-blue-600 text-white text-[0.8rem] font-bold">
                                                    {{ $i }}
                                                </div>
                                            @else
                                                <a href="{{ $assignedTasks->url($i) }}" class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-[#3A3B3C] bg-white dark:bg-[#242526] text-slate-600 dark:text-gray-300 text-[0.8rem] font-medium hover:bg-slate-50 dark:hover:bg-[#3A3B3C] transition-colors">
                                                    {{ $i }}
                                                </a>
                                            @endif
                                        @endif
                                    @endforeach

                                    {{-- Next Page --}}
                                    @if ($assignedTasks->hasMorePages())
                                        <a href="{{ $assignedTasks->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-[#3A3B3C] bg-white dark:bg-[#242526] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @else
                                        <div class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-[#3A3B3C] bg-white dark:bg-[#242526] text-slate-300 dark:text-gray-600 cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-slate-300 dark:text-gray-600 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <h3 class="text-lg font-medium text-slate-800 dark:text-gray-100 mb-1">No hay tareas asignadas
                                </h3>
                                <p class="text-[0.95rem] text-slate-500 dark:text-[#B0B3B8]">Este trabajador no tiene tareas
                                    asignadas aún.</p>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif($user->role === 'instructor')
                <!-- Incidentes del Instructor -->
                <div
                    class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C]">
                    <div class="p-6">
                        <div
                            class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-[#3A3B3C]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.854-.833-2.624 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-gray-100">Incidentes Reportados</h3>
                            </div>
                            <span
                                class="text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">{{ $user->reportedIncidents->count() }}
                                incidentes en total</span>
                        </div>

                        @if($user->reportedIncidents->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->reportedIncidents->sortByDesc('created_at') as $incident)
                                    <div
                                        class="bg-white dark:bg-[#18191A] dark:bg-gray-700 rounded-xl border border-slate-200 dark:border-[#3A3B3C] p-5 hover:border-slate-300 dark:hover:border-gray-500 transition-colors">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <h4 class="text-[1.05rem] font-bold text-slate-800 dark:text-gray-100">
                                                        {{ $incident->title }}
                                                    </h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-bold uppercase tracking-wide
                                                                                                        @if($incident->status === 'resuelto') 
                                                                                                            bg-[#ECFDF5] text-[#059669] dark:bg-[#059669]/20 dark:text-[#34D399]
                                                                                                        @elseif($incident->status === 'en_proceso')
                                                                                                            bg-[#EFF6FF] text-[#2563EB] dark:bg-[#2563EB]/20 dark:text-[#60A5FA]
                                                                                                        @else
                                                                                                            bg-[#FEF2F2] text-[#DC2626] dark:bg-[#DC2626]/20 dark:text-[#F87171]
                                                                                                        @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                                    </span>
                                                </div>

                                                <p class="text-[0.9rem] text-slate-600 dark:text-gray-300 mt-2 mb-3">
                                                    {{ $incident->description }}
                                                </p>

                                                <div
                                                    class="flex items-center gap-4 text-xs font-medium text-slate-500 dark:text-[#B0B3B8]">
                                                    <div class="flex items-center">
                                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Reportado: {{ $incident->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                    @if($incident->updated_at != $incident->created_at)
                                                        <div class="flex items-center">
                                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
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
                                                        <p class="text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">Imágenes
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
                                <svg class="mx-auto h-12 w-12 text-slate-300 dark:text-gray-600 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.854-.833-2.624 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                <h3 class="text-lg font-medium text-slate-800 dark:text-gray-100 mb-1">No hay incidentes
                                    reportados</h3>
                                <p class="text-[0.95rem] text-slate-500 dark:text-[#B0B3B8]">Este instructor no ha reportado
                                    incidentes aún.</p>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                <!-- Para administradores u otros roles -->
                <div
                    class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-200 dark:border-[#3A3B3C]">
                    <div class="p-10 text-center">
                        <div
                            class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center mx-auto mb-5 text-purple-600 dark:text-[#A78BFA]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-gray-100 mb-2">Administrador del Sistema</h3>
                        <p class="text-[0.95rem] text-slate-500 dark:text-[#B0B3B8] max-w-md mx-auto">
                            Los administradores tienen acceso completo al sistema y pueden gestionar todos los usuarios,
                            tareas e incidentes.
                        </p>
                        <div class="mt-8 grid grid-cols-2 gap-4 max-w-sm mx-auto">
                            <div
                                class="bg-slate-50 dark:bg-[#18191A] dark:bg-gray-700 rounded-xl p-4 border border-slate-100 dark:border-[#3A3B3C]">
                                <div class="text-lg font-bold text-slate-800 dark:text-gray-100">Total</div>
                                <div class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-1">Control completo</div>
                            </div>
                            <div
                                class="bg-slate-50 dark:bg-[#18191A] dark:bg-gray-700 rounded-xl p-4 border border-slate-100 dark:border-[#3A3B3C]">
                                <div class="text-lg font-bold text-slate-800 dark:text-gray-100">Global</div>
                                <div class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-1">Permisos</div>
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
                <svg class="w-6 h-6 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a id="downloadButton" href="" download
                class="absolute bottom-4 right-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-full p-3 transition transform hover:scale-110 flex items-center justify-center">
                <svg class="w-6 h-6 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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