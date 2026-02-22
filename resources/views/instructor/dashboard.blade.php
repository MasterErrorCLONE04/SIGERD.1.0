<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Mi Panel de Reportes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-rose-50 to-pink-50 dark:from-gray-900 dark:via-gray-900 dark:to-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Tarjetas de estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                {{-- Total de reportes --}}
                <div class="bg-white dark:bg-[#242526] rounded-2xl shadow-lg border border-gray-100 dark:border-[#3A3B3C] p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300 dark:text-gray-400">Total de Reportes</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mt-2">{{ $totalIncidents }}</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>


                {{-- Asignados --}}
                <div class="bg-white dark:bg-[#242526] rounded-2xl shadow-lg border border-gray-100 dark:border-[#3A3B3C] p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300 dark:text-gray-400">Asignados</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mt-2">{{ $assignedIncidents }}</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Reportes pendientes de revisión --}}
                <div class="bg-white dark:bg-[#242526] rounded-2xl shadow-lg border border-gray-100 dark:border-[#3A3B3C] overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pendientes de Revisión
                        </h3>
                    </div>
                    <div class="p-6">
                        @forelse($pendingIncidents as $incident)
                            <div class="mb-4 last:mb-0 p-4 bg-yellow-50 dark:bg-yellow-900/10 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 dark:text-white">{{ $incident->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">
                                            {{ Str::limit($incident->description, 60) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-500 dark:text-[#B0B3B8] mt-1">
                                            {{ $incident->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <a href="{{ route('instructor.incidents.show', $incident->id) }}" 
                                       class="ml-4 px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 text-center py-8">No tienes reportes pendientes de revisión</p>
                        @endforelse
                    </div>
                </div>

                {{-- Reportes recientes --}}
                <div class="bg-white dark:bg-[#242526] rounded-2xl shadow-lg border border-gray-100 dark:border-[#3A3B3C] overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Reportes Recientes
                        </h3>
                    </div>
                    <div class="p-6">
                        @forelse($recentIncidents as $incident)
                            <div class="mb-4 last:mb-0 p-4 bg-gray-50 dark:bg-[#18191A] rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 dark:text-white">{{ $incident->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">
                                            {{ Str::limit($incident->description, 60) }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-2">
                                            @php
                                                $statusColors = [
                                                    'pendiente de revisión' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300',
                                                    'asignado' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                                    'resuelto' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300',
                                                    'cerrado' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                                ];
                                                $color = $statusColors[$incident->status] ?? 'bg-gray-100 text-gray-800 dark:text-gray-100 dark:bg-gray-500/20 dark:text-gray-300';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                {{ ucfirst($incident->status) }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-[#B0B3B8] dark:text-gray-500 dark:text-[#B0B3B8]">
                                                {{ $incident->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('instructor.incidents.show', $incident->id) }}" 
                                       class="ml-4 px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium rounded-lg transition">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400 text-center py-8">No tienes reportes recientes</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Acceso rápido --}}
            <div class="bg-white dark:bg-[#242526] rounded-2xl shadow-lg border border-gray-100 dark:border-[#3A3B3C] p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-4">Acceso Rápido</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('instructor.incidents.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Reportar Nueva Falla
                    </a>
                    <a href="{{ route('instructor.incidents.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ver Todos mis Reportes
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
