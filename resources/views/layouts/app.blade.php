<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIGERD</title>
    <link rel="icon" href="{{ asset('logo/logo-minimalista.webp') }}" type="image/webp">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Initialization -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-[#18191A]">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Bar (opcional para breadcrumbs, notificaciones, etc.) --}}
            <header
                class="bg-white dark:bg-[#18191A] shadow-sm border-b border-gray-200 dark:border-[#3A3B3C] relative z-40">
                <div class="px-4 py-4 pl-14 lg:pl-8 lg:px-8">
                    <div class="flex items-center justify-between">
                        {{-- Page Heading --}}
                        <div class="flex-1">
                            @isset($header)
                                {{ $header }}
                            @else
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                                    Dashboard
                                </h2>
                            @endisset
                        </div>

                        {{-- Quick Actions / Notifications --}}
                        <div class="flex items-center gap-3">
                            {{-- Notificaciones --}}
                            <div x-data="notificationDropdown()" x-init="init()" class="relative">
                                <button @click="open = !open"
                                    class="relative p-2 text-gray-600 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                                    <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span x-show="unreadCount > 0" x-text="unreadCount"
                                        class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full"></span>
                                </button>

                                {{-- Dropdown de notificaciones --}}
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-96 bg-white dark:bg-[#18191A] rounded-xl shadow-2xl border border-gray-200 dark:border-[#3A3B3C] z-50"
                                    style="display: none;">

                                    {{-- Header --}}
                                    <div
                                        class="px-4 py-3 border-b border-gray-200 dark:border-[#3A3B3C] flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notificaciones
                                        </h3>
                                        <button @click="markAllAsRead()"
                                            class="text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                            Marcar todas como leídas
                                        </button>
                                    </div>

                                    {{-- Lista de notificaciones --}}
                                    <div class="max-h-96 overflow-y-auto">
                                        <template x-if="notifications.length === 0">
                                            <div class="px-4 py-8 text-center">
                                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2 dark:text-white" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-sm text-gray-500 dark:text-[#B0B3B8]">No tienes
                                                    notificaciones</p>
                                            </div>
                                        </template>

                                        <template x-for="notification in notifications" :key="notification.id">
                                            <div @click="markAsRead(notification.id, notification.link)"
                                                :class="notification.read ? 'bg-white dark:bg-[#18191A]' : 'bg-blue-50 dark:bg-blue-900/20'"
                                                class="px-4 py-3 border-b border-gray-200 dark:border-[#3A3B3C] hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition">
                                                <div class="flex items-start gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div :class="getIconColor(notification.type)"
                                                            class="w-10 h-10 rounded-lg flex items-center justify-center">
                                                            <svg x-html="getIcon(notification.type)"
                                                                class="w-5 h-5 dark:text-white"></svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white"
                                                            x-text="notification.title"></p>
                                                        <p class="text-xs text-gray-500 dark:text-[#B0B3B8] mt-1"
                                                            x-text="notification.message"></p>
                                                        <p class="text-xs text-gray-400 dark:text-[#B0B3B8] mt-1"
                                                            x-text="formatDate(notification.created_at)"></p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <span x-show="!notification.read"
                                                            class="w-2 h-2 bg-blue-500 rounded-full block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Usuario Dropdown Button --}}
                            <div x-data="{ userMenuOpen: false }" class="relative">
                                <button @click="userMenuOpen = !userMenuOpen"
                                    class="hidden md:flex items-center gap-3 pl-3 pr-4 py-2 bg-slate-50 dark:bg-[#242526] rounded-xl hover:bg-slate-100 dark:hover:bg-gray-600 transition-colors duration-200 group focus:outline-none">
                                    <div class="text-right flex flex-col justify-center">
                                        <p
                                            class="text-[14px] font-semibold text-slate-700 dark:text-white group-hover:text-slate-900 dark:group-hover:text-white transition leading-none mb-1">
                                            {{ Auth::user()->name }}
                                        </p>
                                        <p class="text-[12px] text-slate-500 dark:text-[#B0B3B8] leading-none">
                                            {{ ucfirst(Auth::user()->role) }}
                                        </p>
                                    </div>
                                    <div class="relative">
                                        @if (Auth::user()->hasProfilePhoto())
                                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                                alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div
                                                class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Chevron icon --}}
                                    <svg class="w-4 h-4 text-slate-600 dark:text-[#B0B3B8] transition-transform duration-200"
                                        :class="{ 'rotate-180': userMenuOpen }" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Menu --}}
                                <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-3 w-72 bg-white dark:bg-[#242526] rounded-[1.25rem] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-slate-200/80 dark:border-[#3A3B3C] z-50 overflow-hidden"
                                    style="display: none;">

                                    {{-- User Info Header --}}
                                    <div class="px-5 py-5 border-b border-slate-100 dark:border-[#3A3B3C]">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                @if (Auth::user()->hasProfilePhoto())
                                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                                        alt="{{ Auth::user()->name }}"
                                                        class="w-14 h-14 rounded-full object-cover">
                                                @else
                                                    <div
                                                        class="w-14 h-14 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-[#242526] rounded-full"></span>
                                            </div>
                                            <div class="flex-1 min-w-0 flex flex-col justify-center">
                                                <p
                                                    class="text-[15px] font-bold text-slate-800 dark:text-white truncate">
                                                    {{ Auth::user()->name }}
                                                </p>
                                                <p
                                                    class="text-[12px] text-slate-500 dark:text-[#B0B3B8] truncate mt-0.5 mb-1.5">
                                                    {{ Auth::user()->email }}
                                                </p>
                                                <div>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold tracking-wider uppercase bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                                        {{ Auth::user()->role }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Menu Items --}}
                                    <div class="py-2">
                                        {{-- Ver Perfil --}}
                                        <a href="{{ route('profile.edit') }}"
                                            class="flex items-center gap-4 px-5 py-2.5 hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 transition border-l-2 border-transparent hover:border-slate-800 dark:hover:border-gray-300">
                                            <div
                                                class="w-9 h-9 bg-slate-100 dark:bg-[#3A3B3C] rounded-xl flex items-center justify-center">
                                                <svg class="w-[18px] h-[18px] text-slate-700 dark:text-white"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <p
                                                    class="text-[14px] font-semibold text-slate-800 dark:text-gray-100 leading-tight">
                                                    Mi Perfil</p>
                                                <p
                                                    class="text-[11px] font-medium text-slate-400 dark:text-[#B0B3B8] leading-tight mt-0.5">
                                                    Ver e información</p>
                                            </div>
                                        </a>

                                        {{-- Configuración --}}
                                        <a href="{{ route('settings.index') }}"
                                            class="flex items-center gap-4 px-5 py-2.5 hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 transition border-l-2 border-transparent hover:border-slate-800 dark:hover:border-gray-300">
                                            <div
                                                class="w-9 h-9 bg-slate-100 dark:bg-[#3A3B3C] rounded-xl flex items-center justify-center">
                                                <svg class="w-[18px] h-[18px] text-slate-700 dark:text-white"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <p
                                                    class="text-[14px] font-semibold text-slate-800 dark:text-gray-100 leading-tight">
                                                    Configuración</p>
                                                <p
                                                    class="text-[11px] font-medium text-slate-400 dark:text-[#B0B3B8] leading-tight mt-0.5">
                                                    Ajustes de cuenta</p>
                                            </div>
                                        </a>

                                        {{-- Soporte --}}
                                        <a href="{{ route('support.index') }}"
                                            class="flex items-center gap-4 px-5 py-2.5 hover:bg-slate-50 dark:hover:bg-[#3A3B3C]/50 transition border-l-2 border-transparent hover:border-slate-800 dark:hover:border-gray-300">
                                            <div
                                                class="w-9 h-9 bg-slate-100 dark:bg-[#3A3B3C] rounded-xl flex items-center justify-center">
                                                <svg class="w-[18px] h-[18px] text-slate-700 dark:text-white"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <p
                                                    class="text-[14px] font-semibold text-slate-800 dark:text-gray-100 leading-tight">
                                                    Soporte</p>
                                                <p
                                                    class="text-[11px] font-medium text-slate-400 dark:text-[#B0B3B8] leading-tight mt-0.5">
                                                    Centro de ayuda</p>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- Divider --}}
                                    <div class="border-t border-slate-100 dark:border-[#3A3B3C]"></div>

                                    {{-- Cerrar Sesión --}}
                                    <div class="py-2">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-4 w-full px-5 py-2.5 hover:bg-rose-50/50 dark:hover:bg-rose-900/10 transition border-l-2 border-transparent hover:border-rose-400 focus:outline-none text-left">
                                                <div
                                                    class="w-9 h-9 bg-rose-50 dark:bg-rose-900/30 rounded-xl flex items-center justify-center">
                                                    <svg class="w-[18px] h-[18px] text-rose-500 dark:text-rose-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                    </svg>
                                                </div>
                                                <div class="flex flex-col justify-center">
                                                    <p
                                                        class="text-[14px] font-semibold text-rose-500 dark:text-rose-400 leading-tight">
                                                        Cerrar Sesión</p>
                                                    <p
                                                        class="text-[10px] uppercase font-bold tracking-wider text-rose-400 dark:text-rose-500 leading-tight mt-0.5">
                                                        DESCONECTAR</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-[#18191A]">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Scripts Stack -->
    @stack('scripts')

    {{-- Script de notificaciones --}}
    <script>
        function notificationDropdown() {
            return {
                open: false,
                notifications: [],
                unreadCount: 0,

                init() {
                    this.fetchNotifications();
                    this.fetchUnreadCount();
                    // Actualizar cada 30 segundos
                    setInterval(() => {
                        this.fetchNotifications();
                        this.fetchUnreadCount();
                    }, 30000);
                },

                async fetchNotifications() {
                    try {
                        const response = await fetch('{{ route("notifications.index") }}');
                        const data = await response.json();
                        this.notifications = data;
                    } catch (error) {
                        console.error('Error fetching notifications:', error);
                    }
                },

                async fetchUnreadCount() {
                    try {
                        const response = await fetch('{{ route("notifications.unread-count") }}');
                        const data = await response.json();
                        this.unreadCount = data.count;
                    } catch (error) {
                        console.error('Error fetching unread count:', error);
                    }
                },

                async markAsRead(id, link) {
                    try {
                        await fetch(`/notifications/${id}/mark-as-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        this.fetchNotifications();
                        this.fetchUnreadCount();

                        if (link) {
                            window.location.href = link;
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                },

                async markAllAsRead() {
                    try {
                        await fetch('{{ route("notifications.mark-all-as-read") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        this.fetchNotifications();
                        this.fetchUnreadCount();
                    } catch (error) {
                        console.error('Error marking all as read:', error);
                    }
                },

                getIcon(type) {
                    const icons = {
                        'incident_created': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                        'task_assigned': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
                        'task_updated': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
                        'task_completed': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'incident_converted': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>',
                    };
                    return icons[type] || icons['task_updated'];
                },

                getIconColor(type) {
                    const colors = {
                        'incident_created': 'bg-red-100 text-red-600',
                        'task_assigned': 'bg-blue-100 text-blue-600',
                        'task_updated': 'bg-yellow-100 text-yellow-600',
                        'task_completed': 'bg-green-100 text-green-600',
                        'incident_converted': 'bg-purple-100 text-purple-600',
                    };
                    return colors[type] || 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-white';
                },

                formatDate(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diff = Math.floor((now - date) / 1000); // diferencia en segundos

                    if (diff < 60) return 'Hace un momento';
                    if (diff < 3600) return `Hace ${Math.floor(diff / 60)} minutos`;
                    if (diff < 86400) return `Hace ${Math.floor(diff / 3600)} horas`;
                    if (diff < 604800) return `Hace ${Math.floor(diff / 86400)} días`;

                    return date.toLocaleDateString('es-ES', {
                        day: '2-digit',
                        month: 'short',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        }
    </script>
</body>

</html>