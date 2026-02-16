{{-- Sidebar para SIGERD con diseño específico por rol --}}
<div x-data="{ sidebarOpen: true, sidebarCollapsed: false }" class="relative">
    {{-- Overlay para móviles --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden" style="display: none;">
    </div>

    {{-- Sidebar --}}
    <aside x-show="sidebarOpen" :class="sidebarCollapsed ? 'w-20' : 'w-72'"
        x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 h-screen bg-gradient-to-b from-blue-50 via-indigo-50 to-purple-50 text-gray-700 shadow-xl border-r border-indigo-200 transform lg:translate-x-0 lg:static flex flex-col transition-all duration-300"
        style="display: flex;">

        {{-- Header del Sidebar --}}
        <div
            class="flex items-center justify-between h-16 px-4 bg-white/60 backdrop-blur-sm border-b border-indigo-200">
            <div class="flex items-center gap-3 min-w-0">
                <div x-show="!sidebarCollapsed" x-transition class="min-w-0">
                    <h1 class="text-xl font-bold tracking-tight truncate">SIGERD</h1>
                    <p class="text-xs text-gray-400 truncate">Sistema de Gestión</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                {{-- Botón para colapsar/expandir (solo desktop) --}}
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="hidden lg:block p-2 rounded-lg hover:bg-indigo-100 text-gray-600 hover:text-indigo-600 transition-all duration-200"
                    title="Colapsar/Expandir sidebar">
                    <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
                {{-- Botón para cerrar (solo móvil) --}}
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-2 rounded-lg hover:bg-indigo-100 text-gray-600 hover:text-indigo-600 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Perfil de Usuario --}}
        <div class="px-4 py-4 border-b border-indigo-200 bg-white/40 backdrop-blur-sm">
            <div class="flex items-center gap-3" :class="sidebarCollapsed ? 'justify-center' : ''">
                <div class="relative flex-shrink-0">
                    @if (Auth::user()->hasProfilePhoto())
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}"
                            class="w-12 h-12 rounded-xl object-cover ring-2 ring-indigo-500/50">
                    @else
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-lg ring-2 ring-indigo-500/50">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-gray-900 rounded-full">
                    </div>
                </div>
                <div x-show="!sidebarCollapsed" x-transition class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-black truncate">{{ Auth::user()->name }}</p>
                    @php
                        $roleColors = [
                            'administrador' => 'bg-blue-100 text-blue-700 border-blue-300',
                            'trabajador' => 'bg-emerald-100 text-emerald-700 border-emerald-300',
                            'instructor' => 'bg-purple-100 text-purple-700 border-purple-300',
                        ];
                        $roleColor = $roleColors[Auth::user()->role] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                    @endphp
                    <span
                        class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded border {{ $roleColor }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Navegación Principal --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto min-h-0">
            <div class="space-y-1">
                @auth
                    {{-- Navegación para ADMINISTRADOR --}}
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Dashboard' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-sm border border-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Usuarios' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-sm border border-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Usuarios</span>
                        </a>

                        <a href="{{ route('admin.tasks.index') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Tareas' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.tasks.*') ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-sm border border-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Tareas</span>
                        </a>

                        <a href="{{ route('admin.incidents.index') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Incidentes' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.incidents.*') ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-sm border border-blue-200' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Incidentes</span>
                        </a>
                    @endif

                    {{-- Navegación para INSTRUCTOR --}}
                    @if (Auth::user()->isInstructor())
                        <a href="{{ route('instructor.dashboard') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Dashboard' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('instructor.dashboard') ? 'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 shadow-sm border border-purple-200' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('instructor.incidents.index') }}"
                            :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Mis Reportes' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('instructor.incidents.*') && !request()->routeIs('instructor.incidents.create') ? 'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 shadow-sm border border-purple-200' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Mis Reportes</span>
                        </a>

                        <a href="{{ route('instructor.incidents.create') }}"
                            :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Reportar Incidente' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('instructor.incidents.create') ? 'bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 shadow-sm border border-purple-200' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Reportar Incidente</span>
                        </a>
                    @endif

                    {{-- Navegación para TRABAJADOR --}}
                    @if (Auth::user()->isTrabajador())
                        <a href="{{ route('worker.dashboard') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Dashboard' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('worker.dashboard') ? 'bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 shadow-sm border border-emerald-200' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('worker.tasks.index') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                            :title="sidebarCollapsed ? 'Mis Tareas' : ''"
                            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('worker.tasks.*') ? 'bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 shadow-sm border border-emerald-200' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Mis Tareas</span>
                        </a>
                    @endif
                @endauth
            </div>
        </nav>

        {{-- Footer del Sidebar --}}
        <div class="px-3 py-4 border-t border-indigo-200 bg-white/40 backdrop-blur-sm space-y-1 mt-auto">
            <a href="{{ route('profile.edit') }}" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                :title="sidebarCollapsed ? 'Configuración' : ''"
                class="flex items-center px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-700 transition-all duration-200">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="font-medium">Configuración</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" :class="sidebarCollapsed ? 'justify-center' : 'gap-3'"
                    :title="sidebarCollapsed ? 'Cerrar Sesión' : ''"
                    class="w-full flex items-center px-3 py-2.5 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition class="font-medium">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Botón para abrir sidebar en móviles --}}
    <button @click="sidebarOpen = true; sidebarCollapsed = false" x-show="!sidebarOpen" x-transition
        class="lg:hidden fixed top-4 left-4 z-30 p-3 bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 rounded-xl shadow-lg border border-blue-200 hover:shadow-xl transition-all duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>