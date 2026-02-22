<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Detalles del Reporte') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-rose-50 to-pink-50 dark:from-gray-900 dark:via-gray-900 dark:to-slate-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Información principal --}}
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden">
                <div class="p-8">
                    {{-- Header con título y estado --}}
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-2">{{ $incident->title }}</h1>
                            <div class="flex items-center gap-3 flex-wrap">
                                @php
                                    $statusColors = [
                                        'pendiente de revisión' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300 border-yellow-300 dark:border-yellow-700',
                                        'asignado' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300 border-blue-300 dark:border-blue-700',
                                        'en progreso' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300 border-indigo-300 dark:border-indigo-700',
                                        'resuelto' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300 border-green-300 dark:border-green-700',
                                        'cerrado' => 'bg-gray-100 text-gray-800 dark:text-gray-100 dark:bg-gray-500/20 dark:text-gray-300 border-gray-300 dark:border-gray-700',
                                    ];
                                    $color = $statusColors[$incident->status] ?? 'bg-gray-100 text-gray-800 dark:text-gray-100 dark:bg-gray-500/20 dark:text-gray-300 border-gray-300 dark:border-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold border {{ $color }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ ucfirst($incident->status) }}
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Reportado {{ $incident->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Descripción del Problema
                        </h3>
                        <p class="text-gray-700 dark:text-gray-200 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $incident->description }}</p>
                    </div>

                    {{-- Información adicional --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Ubicación --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Ubicación
                            </h4>
                            <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">{{ $incident->location }}</p>
                        </div>

                        {{-- Fecha de reporte --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Fecha de Reporte
                            </h4>
                            <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">{{ $incident->report_date->format('d/m/Y') }}</p>
                        </div>

                        {{-- Reportado por --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Reportado por
                            </h4>
                            <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">{{ $incident->reportedBy->name }}</p>
                        </div>

                        {{-- ID del reporte --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                ID del Reporte
                            </h4>
                            <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">#{{ $incident->id }}</p>
                        </div>
                    </div>

                    {{-- Imágenes de evidencia inicial --}}
                    @if ($incident->initial_evidence_images && count($incident->initial_evidence_images) > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Imágenes de Evidencia Inicial
                            </h3>
                            <div class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4">
                                @foreach ($incident->initial_evidence_images as $imagePath)
                                    <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 bg-gray-100 dark:bg-gray-700 cursor-pointer"
                                         onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')">
                                        <img src="{{ asset('storage/' . $imagePath) }}" 
                                             alt="Evidencia Inicial" 
                                             class="w-full h-64 object-cover">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                            </svg>
                                        </div>
                                        <div class="absolute bottom-3 right-3 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200 dark:text-gray-300">Click para ampliar</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Información de resolución (solo si está resuelto) --}}
                    @if ($incident->status === 'resuelto')
                        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-green-900 dark:text-green-100 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Información de Resolución
                            </h3>

                            {{-- Fecha de resolución --}}
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Resuelto el
                                </h4>
                                <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">
                                    {{ $incident->resolved_at->format('d/m/Y H:i:s') }} 
                                    <span class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">({{ $incident->resolved_at->diffForHumans() }})</span>
                                </p>
                            </div>

                            {{-- Descripción de resolución --}}
                            @if ($incident->resolution_description)
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Descripción de la Solución
                                    </h4>
                                    <p class="text-gray-800 dark:text-gray-100 dark:text-gray-200 leading-relaxed whitespace-pre-wrap bg-white/50 dark:bg-gray-800/50 p-4 rounded-lg">{{ $incident->resolution_description }}</p>
                                </div>
                            @endif

                            {{-- Imágenes de evidencia final --}}
                            @if ($incident->final_evidence_images && count($incident->final_evidence_images) > 0)
                                <div>
                                    <h4 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Imágenes de Evidencia Final
                                    </h4>
                                    <div class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4">
                                        @foreach ($incident->final_evidence_images as $imagePath)
                                            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 bg-gray-100 dark:bg-gray-700 cursor-pointer"
                                                 onclick="openImageModal('{{ asset('storage/' . $imagePath) }}')">
                                                <img src="{{ asset('storage/' . $imagePath) }}" 
                                                     alt="Evidencia Final" 
                                                     class="w-full h-64 object-cover">
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                    </svg>
                                                </div>
                                                <div class="absolute top-3 left-3 bg-green-500/90 backdrop-blur-sm px-2.5 py-1 rounded-lg">
                                                    <span class="text-xs font-bold text-white flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Final
                                                    </span>
                                                </div>
                                                <div class="absolute bottom-3 right-3 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-200 dark:text-gray-300">Click para ampliar</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Convertir a tarea --}}
                    @if ($incident->status === 'pendiente de revisión')
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Convertir a Tarea
                            </h3>
                            <form method="POST" action="{{ route('admin.incidents.convert-to-task', $incident->id) }}" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Title -->
                                    <div>
                                        <x-input-label for="task_title" :value="__('Título de la Tarea')" class="text-gray-700 dark:text-gray-200" />
                                        <x-text-input id="task_title" 
                                                      class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" 
                                                      type="text" 
                                                      name="task_title" 
                                                      :value="old('task_title', 'Incidente: ' . $incident->title)" 
                                                      required />
                                        <x-input-error :messages="$errors->get('task_title')" class="mt-2" />
                                    </div>

                                    <!-- Assigned To -->
                                    <div>
                                        <x-input-label for="assigned_to" :value="__('Asignar a')" class="text-gray-700 dark:text-gray-200" />
                                        <select id="assigned_to" 
                                                name="assigned_to" 
                                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" 
                                                required>
                                            <option value="">Selecciona un trabajador</option>
                                            @foreach ($workers as $worker)
                                                <option value="{{ $worker->id }}" {{ old('assigned_to') == $worker->id ? 'selected' : '' }}>{{ $worker->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <x-input-label for="task_description" :value="__('Descripción del Trabajo a Realizar')" class="text-gray-700 dark:text-gray-200" />
                                    <textarea id="task_description" 
                                              name="task_description" 
                                              rows="4"
                                              class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" 
                                              required>{{ old('task_description', $incident->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('task_description')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Priority -->
                                    <div>
                                        <x-input-label for="priority" :value="__('Prioridad')" class="text-gray-700 dark:text-gray-200" />
                                        <select id="priority" 
                                                name="priority" 
                                                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" 
                                                required>
                                            @foreach ($priorities as $priority)
                                                <option value="{{ $priority }}" {{ old('priority') == $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                                    </div>

                                    <!-- Deadline At -->
                                    <div>
                                        <x-input-label for="deadline_at" :value="__('Fecha Límite')" class="text-gray-700 dark:text-gray-200" />
                                        <x-text-input id="deadline_at" 
                                                      class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" 
                                                      type="date" 
                                                      name="deadline_at" 
                                                      :value="old('deadline_at')" 
                                                      required />
                                        <x-input-error :messages="$errors->get('deadline_at')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Location (pre-filled from incident) -->
                                <div>
                                    <x-input-label for="location" :value="__('Ubicación de la Tarea')" class="text-gray-700 dark:text-gray-200" />
                                    <x-text-input id="location" 
                                                  class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" 
                                                  type="text" 
                                                  name="location" 
                                                  :value="old('location', $incident->location)" 
                                                  required />
                                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                                    <a href="{{ route('admin.incidents.index') }}" 
                                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 font-semibold rounded-lg transition">
                                        Cancelar
                                    </a>
                                    <x-primary-button class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        {{ __('Convertir a Tarea') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-[#3A3B3C] dark:border-gray-600">
                            <p class="text-gray-700 dark:text-gray-200 dark:text-gray-300 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500 dark:text-[#B0B3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <strong class="font-medium">Nota:</strong> Este reporte ya ha sido gestionado y su estado actual es <span class="font-semibold">"{{ ucfirst($incident->status) }}"</span>.
                            </p>
                        </div>
                    @endif

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <a href="{{ route('admin.incidents.index') }}" 
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 font-semibold rounded-lg transition shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver a la Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para ver imagen en grande --}}
    <div id="imageModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Imagen ampliada" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 rounded-full p-3 transition-all hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            {{-- Botón de descarga --}}
            <a id="downloadButton" href="" download class="absolute bottom-4 right-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-full p-3 transition-all hover:scale-110 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
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

        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
