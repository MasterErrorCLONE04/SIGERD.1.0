{{-- Sidebar para SIGERD con diseño minimalista --}}
<div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value))"
    @resize.window="sidebarOpen = window.innerWidth >= 1024" class="relative z-50 h-full">
    {{-- Overlay para móviles --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm lg:hidden" style="display: none;">
    </div>

    {{-- Sidebar --}}
    <aside x-show="sidebarOpen" :class="sidebarCollapsed ? 'w-20' : 'w-72'"
        x-transition:enter="transition-transform duration-300 ease-in-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-300 ease-in-out"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 bg-white border-r border-slate-100 flex flex-col transition-all duration-300 lg:translate-x-0 lg:static h-screen shadow-[4px_0_24px_rgba(0,0,0,0.02)]"
        style="display: flex;">

        {{-- Header del Sidebar --}}
        <div class="flex items-center justify-between h-[84px] px-6 border-b border-slate-100 flex-shrink-0">
            <div class="flex items-center gap-3 min-w-0" x-show="!sidebarCollapsed" x-transition>
                <div class="min-w-0">
                    <h1 class="text-xl font-extrabold text-[#1E293B] tracking-tight">SIGERD</h1>
                    <p class="text-[0.7rem] text-slate-500 font-medium tracking-wide">Sistema de Gestión</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                {{-- Toggle Desktop --}}
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="hidden lg:flex p-1.5 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-colors">
                    <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
                {{-- Close Mobile --}}
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Perfil de Usuario --}}
        <div class="px-6 py-6 border-b border-slate-100 flex-shrink-0">
            <div class="flex items-center gap-4" :class="sidebarCollapsed ? 'justify-center w-full ml-[-8px]' : ''">
                <div class="relative flex-shrink-0">
                    @if (Auth::user()->hasProfilePhoto())
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}"
                            class="w-11 h-11 rounded-full object-cover ring-2 ring-[#FEF0C7]/50">
                    @else
                        <div
                            class="w-11 h-11 bg-[#F5E6CC] text-[#B88746] rounded-full flex items-center justify-center font-bold text-lg ring-2 ring-[#FEF0C7]/50">
                            <svg class="w-6 h-6 opacity-60" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-[#10B981] border-2 border-white rounded-full">
                    </div>
                </div>
                <div x-show="!sidebarCollapsed" x-transition class="flex-1 min-w-0">
                    <p class="text-[0.95rem] font-bold text-[#1E293B] truncate">{{ Auth::user()->name }}</p>
                    <div class="mt-0.5">
                        <span
                            class="inline-flex items-center px-2 py-0.5 text-[0.65rem] font-bold rounded-full bg-[#EFF6FF] text-[#3B82F6] capitalize tracking-wide">
                            {{ Auth::user()->role === 'admin' ? 'Full Access' : Auth::user()->role }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navegación Principal --}}
        <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1 custom-scrollbar">
            @auth
                {{-- Navegación para ADMINISTRADOR --}}
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" :title="sidebarCollapsed ? 'Dashboard' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Dashboard</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.users.index') }}" :title="sidebarCollapsed ? 'Usuarios' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.25rem] h-[1.25rem] flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-[#1E293B]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Usuarios</span>
                        @if(request()->routeIs('admin.users.*'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1.5 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.tasks.index') }}" :title="sidebarCollapsed ? 'Tareas' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('admin.tasks.*') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('admin.tasks.*') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Tareas</span>
                        @if(request()->routeIs('admin.tasks.*'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('admin.incidents.index') }}" :title="sidebarCollapsed ? 'Incidentes' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('admin.incidents.*') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('admin.incidents.*') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Incidentes</span>
                        @if(request()->routeIs('admin.incidents.*'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>
                @endif

                {{-- Navegación para INSTRUCTOR --}}
                @if (Auth::user()->isInstructor())
                    <a href="{{ route('instructor.dashboard') }}" :title="sidebarCollapsed ? 'Dashboard' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('instructor.dashboard') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('instructor.dashboard') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Dashboard</span>
                        @if(request()->routeIs('instructor.dashboard'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('instructor.incidents.index') }}" :title="sidebarCollapsed ? 'Mis Reportes' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('instructor.incidents.*') && !request()->routeIs('instructor.incidents.create') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('instructor.incidents.*') && !request()->routeIs('instructor.incidents.create') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Mis Reportes</span>
                        @if(request()->routeIs('instructor.incidents.*') && !request()->routeIs('instructor.incidents.create'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>
                @endif

                {{-- Navegación para TRABAJADOR --}}
                @if (Auth::user()->isTrabajador())
                    <a href="{{ route('worker.dashboard') }}" :title="sidebarCollapsed ? 'Dashboard' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('worker.dashboard') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('worker.dashboard') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Dashboard</span>
                        @if(request()->routeIs('worker.dashboard'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('worker.tasks.index') }}" :title="sidebarCollapsed ? 'Mis Tareas' : ''"
                        class="relative flex items-center px-4 py-[0.85rem] rounded-[10px] transition-colors {{ request()->routeIs('worker.tasks.*') ? 'bg-[#F2F5F8] text-[#1E293B] font-semibold' : 'text-[#64748B] hover:bg-slate-50 hover:text-slate-800 font-medium' }}"
                        :class="sidebarCollapsed ? 'justify-center' : ''">
                        <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 {{ request()->routeIs('worker.tasks.*') ? 'text-[#475569]' : 'text-slate-400' }}"
                            :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Mis Tareas</span>
                        @if(request()->routeIs('worker.tasks.*'))
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 h-7 w-1 bg-[#1E293B] rounded-l-full"></div>
                        @endif
                    </a>
                @endif
            @endauth
        </nav>

        {{-- Footer del Sidebar --}}
        <div class="px-4 py-6 border-t border-slate-100 flex-shrink-0 space-y-2">
            <a href="{{ route('profile.edit') }}" :title="sidebarCollapsed ? 'Configuración' : ''"
                class="flex items-center px-4 py-2.5 rounded-lg text-[#64748B] hover:bg-slate-50 hover:text-[#1E293B] font-medium transition-colors"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="w-[1.15rem] h-[1.15rem] flex-shrink-0 text-slate-400"
                    :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Configuración</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" :title="sidebarCollapsed ? 'Cerrar Sesión' : ''"
                    class="w-full flex items-center px-4 py-2.5 rounded-lg text-[#EF4444] hover:bg-red-50 font-medium transition-colors"
                    :class="sidebarCollapsed ? 'justify-center' : ''">
                    <svg class="w-[1.2rem] h-[1.2rem] flex-shrink-0 text-[#EF4444]"
                        :class="!sidebarCollapsed ? 'mr-3.5' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition class="text-[0.95rem]">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Botón para abrir sidebar en móviles --}}
    <button @click="sidebarOpen = true; sidebarCollapsed = false" x-show="!sidebarOpen" x-transition
        class="lg:hidden fixed top-4 left-4 z-30 p-2.5 bg-white text-slate-700 rounded-lg shadow-sm border border-slate-200 hover:bg-slate-50 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>

<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: transparent;
        border-radius: 10px;
    }

    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #CBD5E1;
    }
</style>