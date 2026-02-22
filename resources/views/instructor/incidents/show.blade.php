<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Detalles del Reporte de Falla') }}
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
                            <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">{{ $incident->location ?? 'No especificada' }}</p>
                        </div>

                        {{-- Fecha de reporte --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Fecha de Reporte
                            </h4>
                            <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">{{ $incident->created_at->format('d/m/Y H:i') }}</p>
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
                        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-2 border-green-300 dark:border-green-700 rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-green-900 dark:text-green-100 flex items-center gap-2">
                                        ✅ Incidente Resuelto
                                    </h3>
                                    <p class="text-sm text-green-700 dark:text-green-300">El problema ha sido solucionado exitosamente</p>
                                </div>
                            </div>

                            {{-- Fecha de resolución --}}
                            <div class="mb-4 bg-white/50 dark:bg-gray-800/30 rounded-lg p-4">
                                <h4 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Fecha de Resolución
                                </h4>
                                <p class="text-gray-900 dark:text-gray-100 dark:text-white font-medium">
                                    {{ $incident->resolved_at->format('d/m/Y H:i:s') }} 
                                    <span class="text-sm text-gray-600 dark:text-gray-300 dark:text-gray-400">({{ $incident->resolved_at->diffForHumans() }})</span>
                                </p>
                            </div>

                            {{-- Descripción de resolución --}}
                            @if ($incident->resolution_description)
                                <div class="mb-4 bg-white/50 dark:bg-gray-800/30 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Descripción de la Solución Aplicada
                                    </h4>
                                    <p class="text-gray-800 dark:text-gray-100 dark:text-gray-200 leading-relaxed whitespace-pre-wrap">{{ $incident->resolution_description }}</p>
                                </div>
                            @endif

                            {{-- Imágenes de evidencia final --}}
                            @if ($incident->final_evidence_images && count($incident->final_evidence_images) > 0)
                                <div class="bg-white/50 dark:bg-gray-800/30 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-green-700 dark:text-green-300 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Imágenes de Evidencia Final del Trabajo Realizado
                                    </h4>
                                    <div class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4 mt-3">
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
                                                {{-- Badge de completado --}}
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

                    {{-- Mensaje de estado actual --}}
                    @if ($incident->status === 'asignado')
                        <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl p-5">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-blue-900 dark:text-blue-100 font-semibold mb-1">🔄 Trabajo en Progreso</p>
                                    <p class="text-blue-700 dark:text-blue-300 text-sm">Este reporte ya ha sido asignado a un trabajador. Te notificaremos cuando esté resuelto y podrás ver las evidencias del trabajo realizado.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($incident->status === 'pendiente de revisión')
                        <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-xl p-5">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-yellow-900 dark:text-yellow-100 font-semibold mb-1">⏳ Pendiente de Revisión</p>
                                    <p class="text-yellow-700 dark:text-yellow-300 text-sm">Este reporte está siendo revisado por el equipo administrativo. Pronto será convertido en una tarea y asignado a un trabajador.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-[#3A3B3C] dark:border-gray-700">
                        <a href="{{ route('instructor.incidents.index') }}" 
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
            <a id="downloadButton" href="" download class="absolute bottom-4 right-4 text-white bg-rose-600 hover:bg-rose-700 rounded-full p-3 transition-all hover:scale-110 shadow-lg">
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
