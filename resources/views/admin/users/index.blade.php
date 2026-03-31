<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-[#F1F2F4] dark:bg-[#3A3B3C] rounded-2xl flex items-center justify-center text-black dark:text-[#E6E9ED] flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-gray-100 tracking-tight">Usuarios del Sistema</h2>
                <p class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">Gestiona todos los usuarios
                    registrados en la plataforma.</p>
            </div>
        </div>
    </x-slot>
    <div class="p-6 lg:p-8 bg-slate-50 dark:bg-[#18191A] min-h-screen">
        <div class="max-w-full mx-auto space-y-6">

            <!-- Filter Bar -->
            <div
                class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-sm border border-slate-200/60 dark:border-[#3A3B3C] p-4 md:p-5">
                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-5 w-full">

                    @if(request('search'))
                        <!-- Info Section -->
                        <div class="flex items-center gap-3 px-2 w-full xl:w-auto">
                            <div
                                class="p-2 bg-[#F1F2F4] dark:bg-[#3A3B3C] rounded-xl text-black dark:text-[#E6E9ED] flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[0.85rem] text-slate-600 dark:text-[#B0B3B8]">
                                    Se encontraron <strong
                                        class="text-slate-800 dark:text-gray-100">{{ $users->count() }}</strong>
                                    resultado(s) para <span
                                        class="text-slate-800 dark:text-gray-100 font-medium">"{{ request('search') }}"</span>
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Search & Actions Form -->
                    <div
                        class="flex flex-col lg:flex-row items-center justify-between gap-4 w-full flex-wrap @if(!request('search')) xl:ml-auto @endif">
                        <form method="GET" action="{{ route('admin.users.index') }}"
                            class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto flex-grow">
                            <!-- Search Input -->
                            <div class="relative w-full sm:w-64 lg:w-96 flex-grow">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 dark:text-[#9CA3AF]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Buscar por nombre, correo, etc..."
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 dark:bg-[#18191A] border border-slate-200/80 dark:border-[#3A3B3C] rounded-xl text-sm text-slate-700 dark:text-gray-200 placeholder-slate-400/80 focus:outline-none focus:ring-2 focus:ring-[#4F46E5]/50 focus:border-[#4F46E5] transition-colors shadow-sm">
                                @if(request('search'))
                                    <a href="{{ route('admin.users.index') }}"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#4F46E5] transition-colors"
                                        title="Limpiar búsqueda">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            <!-- Search & Clear Buttons -->
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <!-- Submit Button (Magnifying Glass) -->
                                <button type="submit" 
                                    class="flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-slate-700 dark:text-gray-200 rounded-xl transition-colors font-medium text-[0.85rem] shadow-sm flex-shrink-0" 
                                    title="Buscar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>

                                <!-- Clear Button -->
                                @if(request('search'))
                                    <a href="{{ route('admin.users.index') }}" 
                                        class="flex items-center justify-center px-4 py-2.5 bg-[#F4F6FF] hover:bg-[#E0E7FF] dark:bg-[#3A3B3C] dark:hover:bg-indigo-900/40 text-[#4F46E5] dark:text-[#E6E9ED] rounded-xl transition-colors font-medium text-[0.85rem] gap-1.5 shadow-sm flex-shrink-0" 
                                        title="Limpiar búsqueda">
                                        <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 w-full lg:w-auto flex-shrink-0">
                            <button onclick="openModal('createUserModal')"
                                class="flex-1 lg:flex-none flex items-center justify-center gap-2 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white px-5 py-2.5 rounded-xl text-[0.85rem] font-medium transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 whitespace-nowrap">
                                <svg class="w-4 h-4 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Crear Usuario
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div
                class="bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-sm border border-slate-200/60 dark:border-[#3A3B3C] overflow-hidden flex flex-col min-h-[500px]">
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-[#3A3B3C]">
                                <th
                                    class="px-8 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400 dark:text-[#9CA3AF]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Usuario
                                </th>
                                <th
                                    class="px-8 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-[#9CA3AF]" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Email
                                    </div>
                                </th>
                                <th
                                    class="px-8 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-[#9CA3AF]" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        Rol
                                    </div>
                                </th>
                                <th
                                    class="px-8 py-5 text-[11px] font-bold text-slate-500 dark:text-[#B0B3B8] uppercase tracking-widest text-right">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70 dark:divide-[#3A3B3C]">
                            @forelse ($users as $user)
                                <tr class="hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="relative flex-shrink-0">
                                                @if($user->hasProfilePhoto())
                                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                                        class="w-12 h-12 rounded-[0.8rem] object-cover bg-slate-100 dark:bg-[#3A3B3C] ring-1 ring-slate-200/50">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-[0.8rem] bg-[#E8E8E8] text-slate-600 dark:text-gray-300 flex items-center justify-center font-bold text-sm ring-1 ring-slate-200/50">
                                                        {{ $user->initials }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-[0.95rem] font-bold text-slate-800 dark:text-gray-100">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-[0.8rem] text-slate-500 dark:text-[#B0B3B8] mt-0.5">ID:
                                                    {{ $user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-[0.95rem] text-slate-700 dark:text-gray-200 font-medium">
                                            {{ $user->email }}
                                        </div>
                                        <div
                                            class="flex items-center gap-1.5 mt-1 text-[0.8rem] text-[#10B981] font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Verificado
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div
                                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-[0.8rem] font-semibold tracking-wide
                                                                                                                        @if($user->role === 'admin') bg-[#F5F3FF] text-[#6D28D9]
                                                                                                                        @elseif($user->role === 'coordinador') bg-[#EFF6FF] text-[#2563EB]
                                                                                                                        @elseif($user->role === 'instructor') bg-[#F1F5F9] text-[#475569]
                                                                                                                        @else bg-[#F1F5F9] text-[#475569]
                                                                                                                        @endif">
                                            @if($user->role === 'admin' || $user->role === 'administrador')
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @elseif($user->role === 'coordinador')
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                                                        clip-rule="evenodd" />
                                                    <path
                                                        d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 016.576-3.149 11.026 11.026 0 01-3.006-.898zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 11.026 11.026 0 01-3.006.898 3.75 3.75 0 016.576 3.149l-.01.121a.563.563 0 01-.373.487l-.115.04c-.567.198-1.157.349-1.764.44z" />
                                                </svg>
                                            @elseif($user->role === 'instructor')
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z" />
                                                    <path
                                                        d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z" />
                                                    <path
                                                        d="M4.462 19.462c.42-.419.753-.89 1-1.394.453.213.902.434 1.347.662a6.742 6.742 0 01-1.286 1.794.75.75 0 01-1.06-1.062z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M7.5 5.25A3.25 3.25 0 0110.75 2h2.5A3.25 3.25 0 0116.5 5.25V6h3.625c.621 0 1.125.504 1.125 1.125v2.413A1.5 1.5 0 0020.25 9.6h-16.5A1.5 1.5 0 002.75 9.538V7.125C2.75 6.504 3.254 6 3.875 6H7.5v-.75zm1.5 0V6h6v-.75a1.75 1.75 0 00-1.75-1.75h-2.5A1.75 1.75 0 009 5.25z"
                                                        clip-rule="evenodd" />
                                                    <path
                                                        d="M2.75 11.25V17.5A2.25 2.25 0 005 19.75h14A2.25 2.25 0 0021 17.5v-6.25H2.75z" />
                                                </svg>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div
                                            class="flex items-center justify-end gap-1.5 text-slate-400 dark:text-[#9CA3AF] opacity-80 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="p-2 hover:bg-slate-100 dark:bg-[#3A3B3C] hover:text-slate-700 dark:text-gray-200 rounded-lg transition-colors"
                                                title="Ver detalle">
                                                <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button type="button" onclick="startEditUser({{ $user->id }})"
                                                class="p-2 hover:bg-[#F0F5FF] hover:text-[#2563EB] rounded-lg transition-colors"
                                                title="Editar usuario">
                                                <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <form id="delete-user-{{ $user->id }}"
                                                action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" x-data @click="$dispatch('confirm-action', {
                                                            title: '¿Eliminar este usuario?',
                                                            message: 'El usuario \'{{ addslashes($user->name) }}\' será eliminado permanentemente junto con todos sus datos asociados. Esta acción no se puede deshacer.',
                                                            variant: 'danger',
                                                            confirmText: 'Sí, eliminar',
                                                            formId: 'delete-user-{{ $user->id }}'
                                                        })"
                                                    class="p-2 hover:bg-[#FEF2F2] hover:text-[#DC2626] rounded-lg transition-colors cursor-pointer"
                                                    title="Eliminar usuario">
                                                    <svg class="w-[1.1rem] h-[1.1rem]" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-[#F4F6FF] dark:bg-[#3A3B3C] rounded-[1.5rem] flex items-center justify-center mb-6 ring-4 ring-[#F4F6FF]/50 dark:ring-indigo-900/10 transition-transform hover:scale-105 duration-300">
                                                @if(request('search'))
                                                    <svg class="w-12 h-12 text-[#4F46E5] dark:text-[#E6E9ED]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-12 h-12 text-[#4F46E5] dark:text-[#E6E9ED]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <h3
                                                class="text-xl font-bold text-slate-800 dark:text-gray-100 mb-2 tracking-tight">
                                                @if(request('search'))
                                                    No se encontraron resultados
                                                @else
                                                    No hay usuarios registrados
                                                @endif
                                            </h3>
                                            <p
                                                class="text-slate-500 dark:text-[#B0B3B8] text-[0.95rem] max-w-sm mx-auto leading-relaxed">
                                                @if(request('search'))
                                                    No encontramos ningún usuario que coincida con
                                                    <span
                                                        class="font-medium text-slate-700 dark:text-gray-200">"{{ request('search') }}"</span>.
                                                    Intenta usar otras palabras
                                                    clave.
                                                @else
                                                    Aún no tienes ningún usuario en el sistema. Puedes empezar añadiendo uno
                                                    nuevo.
                                                @endif
                                            </p>
                                            @if(!request('search'))
                                                <button onclick="openModal('createUserModal')"
                                                    class="mt-8 inline-flex items-center gap-2 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white px-6 py-3 rounded-xl text-[0.95rem] font-medium transition-all shadow-sm focus:ring-2 focus:ring-slate-200/50 hover:shadow-md hover:-translate-y-0.5">
                                                    <svg class="w-5 h-5 !text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Crear Usuario
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                @if ($users->hasPages() || $users->total() > 0)
                    <div
                        class="px-8 py-5 border-t border-slate-100 dark:border-[#3A3B3C] flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
                        <div class="text-[0.85rem] text-slate-500 dark:text-[#B0B3B8] font-medium">
                            Mostrando <span
                                class="font-bold text-slate-700 dark:text-gray-200">{{ $users->firstItem() ?? 0 }}</span> a
                            <span class="font-bold text-slate-700 dark:text-gray-200">{{ $users->lastItem() ?? 0 }}</span>
                            de <span class="font-bold text-slate-700 dark:text-gray-200">{{ $users->total() }}</span>
                            resultados
                        </div>

                        <div class="flex items-center gap-1.5">
                            {{-- Botón Anterior --}}
                            @if ($users->onFirstPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] hover:border-slate-300 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Páginas Numeradas --}}
                            <div class="hidden sm:flex items-center gap-1.5 mx-1">
                                @foreach ($users->getUrlRange(max(1, $users->currentPage() - 1), min($users->lastPage(), $users->currentPage() + 1)) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <span
                                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#1A202C] dark:bg-[#3A3B3C] text-white text-[0.85rem] font-bold shadow-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-transparent text-slate-600 dark:text-gray-300 hover:border-slate-200 dark:border-[#3A3B3C] hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] text-[0.85rem] font-semibold transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Botón Siguiente --}}
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-600 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-[#3A3B3C] dark:bg-[#18191A] hover:border-slate-300 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-[#3A3B3C] text-slate-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Modal para Crear Usuario -->
    @include('modals.admin-create-user')

    <!-- Modal para Editar Usuario -->
    @include('modals.admin-edit-user')

    <script>
        const usersData = @json($users->items());

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function startEditUser(userId) {
            const user = usersData.find(u => u.id == userId);
            if (!user) {
                console.error("User not found");
                return;
            }

            // Actualizar action del form
            const form = document.getElementById('editUserForm');
            form.action = `/admin/users/${user.id}`;

            // Poblar campos
            document.getElementById('edit_user_name').value = user.name;
            document.getElementById('edit_user_email').value = user.email;
            document.getElementById('edit_user_role').value = user.role;

            // Actualizar preview y placeholder de la foto si existe
            const previewImg = document.getElementById('editPreviewImg');
            const initialsPlaceholder = document.getElementById('editInitialsPlaceholder');

            if (user.profile_photo) {
                previewImg.src = `/storage/${user.profile_photo}`;
                previewImg.classList.remove('hidden');
                initialsPlaceholder.classList.add('hidden');
            } else {
                previewImg.classList.add('hidden');
                initialsPlaceholder.classList.remove('hidden');
                // Iniciales logic
                const names = user.name.trim().split(' ');
                let initials = '';
                names.forEach(n => {
                    if (n) initials += n.charAt(0).toUpperCase();
                });
                initialsPlaceholder.textContent = initials.substring(0, 2) || '?';
            }

            openModal('editUserModal');
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal('createUserModal');
                closeModal('editUserModal');
            }
        });

        // Mostrar el modal si hay errores de validación
        @if ($errors->any())
            window.onload = function () {
                @if(old('_method') == 'PUT')
                    // Logic to reopen edit modal would require knowing which ID failed.
                    // For now, if it's an update failure, we can try to find from action URL if possible, or just fail silently.
                    openModal('editUserModal');
                @else
                    openModal('createUserModal');
                @endif
                                        };
        @endif
    </script>
</x-app-layout>