<x-app-layout>

    <div class="h-full p-6 lg:p-8">
        <div class="max-w-full mx-auto h-full flex flex-col">
            <!-- Header mejorado con gradiente y mejor espaciado -->
            <div class="mb-8">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Usuarios del Sistema</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    @if(request('search'))
                                        Se encontraron <strong class="text-gray-900 dark:text-white">{{ $users->count() }}</strong> resultado(s) para "{{ request('search') }}"
                                    @else
                                        Gestiona todos los usuarios registrados en la plataforma
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Barra de búsqueda y acciones mejoradas -->
                        <div class="flex flex-col sm:flex-row gap-4 lg:min-w-96">
                            <form method="GET" action="{{ route('admin.users.index') }}" class="relative flex-1">
                                <input type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar por nombre o email..." 
                                    class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl bg-white/80 dark:bg-gray-700/80 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm hover:shadow-md">
                                <div class="absolute left-4 top-3.5">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" 
                                       title="Limpiar búsqueda">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                @endif
                            </form>
                            <a href="{{ route('admin.users.create') }}" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Crear Usuario
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla mejorada con efectos glass y mejores colores -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden flex-1 flex flex-col">
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/70 dark:to-gray-800/70 backdrop-blur-sm">
                            <tr>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Usuario</span>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Email</span>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        <span>Rol</span>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-right text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach ($users as $user)
                                <tr class="group hover:bg-blue-50/50 dark:hover:bg-gray-700/30 transition-all duration-200 hover:shadow-md">
                                    <!-- Avatar y información del usuario mejorados -->
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                @if($user->profile_photo)
                                                    <img src="{{ $user->profile_photo_url }}" 
                                                         alt="{{ $user->name }}"
                                                         class="h-14 w-14 rounded-2xl object-cover shadow-lg ring-4 ring-white/50 dark:ring-gray-700/50 group-hover:scale-110 transition-transform duration-200">
                                                @else
                                                    <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg shadow-lg ring-4 ring-white/50 dark:ring-gray-700/50 group-hover:scale-110 transition-transform duration-200">
                                                        {{ $user->initials }}
                                                    </div>
                                                @endif
                                                <div class="absolute -bottom-1 -right-1 h-5 w-5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full shadow-sm"></div>
                                            </div>
                                            <div>
                                                <div class="text-base font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                                        </svg>
                                                        ID: {{ $user->id }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Email mejorado -->
                                    <td class="px-8 py-6">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->email }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Verificado ✓
                                        </div>
                                    </td>
                                    
                                    <!-- Badge de rol mejorado con más colores y efectos -->
                                    <td class="px-8 py-6">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold shadow-lg transform group-hover:scale-105 transition-all duration-200
                                            @if($user->role === 'admin') 
                                                bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-purple-500/30
                                            @elseif($user->role === 'moderator')
                                                bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-blue-500/30
                                            @elseif($user->role === 'editor')
                                                bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-green-500/30
                                            @else
                                                bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-gray-500/30
                                            @endif">
                                            @if($user->role === 'admin')
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            @elseif($user->role === 'moderator')
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    
                                    <!-- Botones de acción mejorados -->
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-end space-x-3">
                                            <!-- Botón Ver -->
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 bg-gray-100/80 hover:bg-gray-200/80 dark:bg-gray-700/50 dark:hover:bg-gray-600/50 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Ver
                                            </a>
                                            
                                            <!-- Botón Editar -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 bg-blue-100/80 hover:bg-blue-200/80 dark:bg-blue-900/30 dark:hover:bg-blue-800/40 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Editar
                                            </a>
                                            
                                            <!-- Botón Eliminar -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 bg-red-100/80 hover:bg-red-200/80 dark:bg-red-900/30 dark:hover:bg-red-800/40 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Estado vacío mejorado -->
                @if($users->isEmpty())
                    <div class="text-center py-16">
                        <div class="max-w-sm mx-auto">
                            <div class="mb-6">
                                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-xl">
                                    @if(request('search'))
                                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            @if(request('search'))
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No se encontraron resultados</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">No hay usuarios que coincidan con "<strong class="text-gray-900 dark:text-white">{{ request('search') }}</strong>".</p>
                                <a href="{{ route('admin.users.index') }}" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Limpiar búsqueda
                                </a>
                            @else
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay usuarios registrados</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-8">Comienza creando tu primer usuario para gestionar el sistema.</p>
                                <a href="{{ route('admin.users.create') }}" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Crear Primer Usuario
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Paginación mejorada (opcional) -->
            @if(method_exists($users, 'links'))
                <div class="mt-8">
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl border border-white/20 dark:border-gray-700/50 p-4">
                        {{ $users->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>