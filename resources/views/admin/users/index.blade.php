<x-app-layout>
    <div class="p-6 lg:p-8 bg-slate-50 min-h-screen">
        <div class="max-w-full mx-auto space-y-6">

            <!-- Header Card -->
            <div class="bg-white rounded-[1.25rem] shadow-sm border border-slate-200/60 p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-[#F4F6FF] rounded-2xl flex items-center justify-center text-[#4F46E5]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[1.35rem] font-bold text-slate-800 tracking-tight">Usuarios del Sistema</h2>
                            <p class="text-sm text-slate-500 mt-1">
                                @if(request('search'))
                                    Se encontraron <strong class="text-slate-800">{{ $users->count() }}</strong>
                                    resultado(s) para "{{ request('search') }}"
                                @else
                                    Gestiona todos los usuarios registrados en la plataforma.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="relative w-full md:w-auto">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar por nombre, email..."
                                class="w-full md:w-72 pl-10 pr-4 py-2.5 bg-white border border-slate-200/80 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-300 transition-colors">
                        </form>
                        <button onclick="openModal('createUserModal')"
                            class="flex items-center gap-2 bg-[#1A202C] hover:bg-[#2D3748] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm focus:ring-2 focus:ring-slate-200 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Crear Usuario
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div
                class="bg-white rounded-[1.25rem] shadow-sm border border-slate-200/60 overflow-hidden flex flex-col min-h-[500px]">
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th
                                    class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Usuario
                                </th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Email
                                    </div>
                                </th>
                                <th class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        Rol
                                    </div>
                                </th>
                                <th
                                    class="px-8 py-5 text-[11px] font-bold text-slate-500 uppercase tracking-widest text-right">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/70">
                            @forelse ($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="relative flex-shrink-0">
                                                @if($user->hasProfilePhoto())
                                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                                        class="w-12 h-12 rounded-[0.8rem] object-cover bg-slate-100 ring-1 ring-slate-200/50">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-[0.8rem] bg-[#E8E8E8] text-slate-600 flex items-center justify-center font-bold text-sm ring-1 ring-slate-200/50">
                                                        {{ $user->initials }}
                                                    </div>
                                                @endif
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-[#10B981] border-2 border-white rounded-full">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-[0.95rem] font-bold text-slate-800">{{ $user->name }}</div>
                                                <div class="text-[0.8rem] text-slate-500 mt-0.5">ID: {{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-[0.95rem] text-slate-700 font-medium">{{ $user->email }}</div>
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
                                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-[0.8rem] font-semibold tracking-wide
                                                @if($user->role === 'admin') bg-[#F5F3FF] text-[#6D28D9]
                                                @elseif($user->role === 'coordinador') bg-[#EFF6FF] text-[#2563EB]
                                                @elseif($user->role === 'instructor') bg-[#F1F5F9] text-[#475569]
                                                @else bg-[#F1F5F9] text-[#475569]
                                                @endif">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($user->role === 'admin')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                @elseif($user->role === 'coordinador')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                    </path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                                    </path>
                                                @endif
                                            </svg>
                                            {{ ucfirst($user->role) }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2.5">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-600 hover:text-slate-800 text-[0.8rem] font-semibold rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Ver
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#F0F5FF] hover:bg-[#E0EBFF] text-[#2563EB] text-[0.8rem] font-semibold rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#FEF2F2] hover:bg-[#FEE2E2] text-[#DC2626] text-[0.8rem] font-semibold rounded-lg transition-colors border-none cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center text-slate-500">
                                        <div class="flex items-center justify-center flex-col">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                </path>
                                            </svg>
                                            <span>No se encontraron usuarios.</span>
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
                        class="px-8 py-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
                        <div class="text-[0.85rem] text-slate-500 font-medium">
                            Mostrando <span class="font-bold text-slate-700">{{ $users->firstItem() ?? 0 }}</span> a <span
                                class="font-bold text-slate-700">{{ $users->lastItem() ?? 0 }}</span> de <span
                                class="font-bold text-slate-700">{{ $users->total() }}</span> resultados
                        </div>

                        <div class="flex items-center gap-1.5">
                            {{-- Botón Anterior --}}
                            @if ($users->onFirstPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
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
                                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#1A202C] text-white text-[0.85rem] font-bold shadow-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 text-[0.85rem] font-semibold transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Botón Siguiente --}}
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
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
    <div id="createUserModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
                onclick="closeModal('createUserModal')"></div>

            <!-- Modal Panel -->
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/20 dark:border-gray-700">
                <div class="p-8">
                    <!-- Header del Modal -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white" id="modal-title">Nuevo
                                    Usuario</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Completa la información para crear un
                                    nuevo usuario</p>
                            </div>
                        </div>
                        <button onclick="closeModal('createUserModal')"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Foto de perfil -->
                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Foto de
                                Perfil</label>
                            <div class="flex items-start space-x-6">
                                <div class="shrink-0">
                                    <div id="imagePreview"
                                        class="h-24 w-24 rounded-2xl bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg shadow-lg ring-4 ring-white/50 dark:ring-gray-700/50 overflow-hidden">
                                        <span id="initialsPlaceholder">?</span>
                                        <img id="previewImg" class="h-full w-full object-cover hidden" alt="Preview">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="relative">
                                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                            class="hidden" onchange="previewImage(this)">
                                        <label for="profile_photo"
                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Seleccionar foto
                                        </label>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">JPG, PNG, GIF hasta 2MB.
                                        Opcional.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300">Nombre
                                    Completo</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                    oninput="updateInitials(this.value)"
                                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                    placeholder="Nombre completo">
                            </div>
                            <div class="space-y-2">
                                <label for="email"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300">Correo
                                    Electrónico</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                    placeholder="usuario@ejemplo.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="password"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300">Contraseña</label>
                                <input id="password" name="password" type="password" required
                                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                    placeholder="••••••••">
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300">Confirmar
                                    Contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-bold text-gray-700 dark:text-gray-300">Rol del
                                Usuario</label>
                            <select id="role" name="role" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                                <option value="">Selecciona un rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center justify-end space-x-4 pt-6">
                            <button type="button" onclick="closeModal('createUserModal')"
                                class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-xl font-semibold transition-all shadow-sm">Cancelar</button>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all shadow-lg transform hover:scale-105">Crear
                                Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function previewImage(input) {
            const preview = document.getElementById('previewImg');
            const placeholder = document.getElementById('initialsPlaceholder');

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

        function updateInitials(name) {
            const placeholder = document.getElementById('initialsPlaceholder');
            const preview = document.getElementById('previewImg');

            if (preview.classList.contains('hidden')) {
                if (name.trim()) {
                    const names = name.trim().split(' ');
                    let initials = '';
                    names.forEach(n => { if (n) initials += n.charAt(0).toUpperCase(); });
                    placeholder.textContent = initials.substring(0, 2) || '?';
                } else {
                    placeholder.textContent = '?';
                }
            }
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal('createUserModal');
        });

        // Mostrar el modal si hay errores de validación
        @if ($errors->any())
            window.onload = function () {
                openModal('createUserModal');
            };
        @endif
    </script>
</x-app-layout>