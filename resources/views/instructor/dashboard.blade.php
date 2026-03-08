<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-[#F1F2F4] dark:bg-[#3A3B3C] rounded-2xl flex items-center justify-center text-black dark:text-[#E6E9ED] flex-shrink-0">
                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Mi Panel de Reportes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-slate-50/50 dark:bg-[#18191A] min-h-screen">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Top Row: Acceso Rápido and Metrics --}}
            <div class="flex flex-col xl:flex-row gap-6">
                {{-- Acceso rápido --}}
                <div
                    class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200/60 dark:border-[#3A3B3C] p-6 flex-1">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-gray-100 mb-5">Acceso Rápido</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="javascript:void(0)" onclick="openModal('createIncidentModal')"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white font-semibold rounded-xl text-sm transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 focus:outline-none">
                            <svg class="w-5 h-5 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Reportar Nueva Falla
                        </a>
                        <a href="{{ route('instructor.incidents.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white font-semibold rounded-xl text-sm transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 focus:outline-none">
                            <svg class="w-5 h-5 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Ver Todos mis Reportes
                        </a>
                    </div>
                </div>

                {{-- Tarjetas de métricas (compactas on the right) --}}
                <div class="flex flex-col sm:flex-row gap-6 xl:w-[480px]">
                    {{-- Total de reportes --}}
                    <div
                        class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200/60 dark:border-[#3A3B3C] p-6 flex-1 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[13px] font-medium text-slate-500 dark:text-gray-400">Total de Reportes
                                </p>
                                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">
                                    {{ $totalIncidents }}
                                </p>
                            </div>
                            <div class="p-2 bg-slate-50 dark:bg-gray-800 rounded-lg text-slate-700 dark:text-gray-200">
                                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Asignados --}}
                    <div
                        class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200/60 dark:border-[#3A3B3C] p-6 flex-1 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[13px] font-medium text-slate-500 dark:text-gray-400">Asignados</p>
                                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">
                                    {{ $assignedIncidents }}
                                </p>
                            </div>
                            <div class="p-2 bg-slate-50 dark:bg-gray-800 rounded-lg text-slate-700 dark:text-gray-200">
                                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5h6m-6 4h6m-6 4h6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Row: Two Columns --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Pendientes de revisión --}}
                <div
                    class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200/60 dark:border-[#3A3B3C] flex flex-col min-h-[500px]">
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-[#3A3B3C]">
                        <h3 class="text-[15px] font-bold text-slate-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-800 dark:text-gray-100" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pendientes de Revisión
                        </h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        @forelse($pendingIncidents as $incident)
                            <div
                                class="mb-4 last:mb-0 p-5 bg-white border border-slate-100 dark:bg-[#18191A] dark:border-[#3A3B3C] rounded-2xl hover:shadow-sm transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="pr-4">
                                        <h4 class="font-semibold text-slate-800 dark:text-gray-100 text-[15px]">
                                            {{ $incident->title }}
                                        </h4>
                                        <p class="text-[14px] text-slate-500 dark:text-gray-400 mt-1 leading-relaxed">
                                            {{ Str::limit($incident->description, 70) }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-3">
                                            <span class="text-[13px] text-slate-400 dark:text-gray-500">
                                                No revisado aún
                                            </span>
                                            <span class="text-[13px] text-slate-400 dark:text-gray-500">
                                                {{ $incident->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('instructor.incidents.show', $incident->id) }}"
                                        class="flex-shrink-0 px-4 py-2 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white text-[13px] font-semibold rounded-lg transition-colors focus:ring-2 focus:ring-slate-200 focus:outline-none">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div
                                class="h-full flex-1 flex flex-col items-center justify-center text-slate-400 dark:text-gray-500 min-h-[250px]">
                                <p class="text-[14.5px]">No tienes reportes pendientes de revisión</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Reportes recientes --}}
                <div
                    class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200/60 dark:border-[#3A3B3C] flex flex-col min-h-[500px]">
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-[#3A3B3C]">
                        <h3 class="text-[15px] font-bold text-slate-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-800 dark:text-gray-100" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Reportes Recientes
                        </h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        @forelse($recentIncidents as $incident)
                            <div
                                class="mb-4 last:mb-0 p-5 bg-white border border-slate-100 dark:bg-[#18191A] dark:border-[#3A3B3C] rounded-2xl hover:shadow-sm transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="pr-4">
                                        <h4 class="font-semibold text-slate-800 dark:text-gray-100 text-[15px]">
                                            {{ $incident->title }}
                                        </h4>
                                        <p class="text-[14px] text-slate-500 dark:text-gray-400 mt-1 leading-relaxed">
                                            {{ Str::limit($incident->description, 70) }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-3">
                                            @php
                                                $statusColors = [
                                                    'pendiente de revisión' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    'asignado' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                                    'resuelto' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                                    'cerrado' => 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                ];
                                                $color = $statusColors[$incident->status] ?? 'bg-slate-100 text-slate-700 dark:bg-gray-800 dark:text-gray-300';
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[12px] font-medium {{ $color }}">
                                                {{ ucfirst($incident->status) }}
                                            </span>
                                            <span class="text-[13px] text-slate-400 dark:text-gray-500">
                                                {{ $incident->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('instructor.incidents.show', $incident->id) }}"
                                        class="flex-shrink-0 px-4 py-2 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white text-[13px] font-semibold rounded-lg transition-colors focus:ring-2 focus:ring-slate-200 focus:outline-none">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div
                                class="h-full flex-1 flex flex-col items-center justify-center text-slate-400 dark:text-gray-500 min-h-[250px]">
                                <p class="text-[14.5px]">No tienes reportes recientes</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @include('modals.instructor-create-incident')

                @push('scripts')
                    <script>
                        function openModal(modalId) {
                            document.getElementById(modalId).classList.remove('hidden');
                        }

                        function closeModal(modalId) {
                            document.getElementById(modalId).classList.add('hidden');
                        }
                    </script>
                @endpush
</x-app-layout>