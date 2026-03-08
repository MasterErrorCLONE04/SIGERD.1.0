<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGERD - Sistema de Gestión de Reportes de Daños</title>
    <meta name="description"
        content="SIGERD es el sistema integral para gestionar reportes de daños e incidencias en infraestructura. Control total, trazabilidad y eficiencia operativa.">
    <link rel="icon" href="{{ asset('logo/logo-minimalista.webp') }}" type="image/webp">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #1A202C;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.7s ease-out forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body class="antialiased">

    <!-- Navbar -->
    <header class="bg-white/80 backdrop-blur-xl fixed top-0 w-full z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex justify-between items-center h-[72px]">
                <!-- Logo -->
                <a href="/" class="flex items-center hover:opacity-80 transition-opacity">
                    <img src="{{ asset('logo/logo.webp') }}" alt="SIGERD Logo" class="h-11 w-auto">
                </a>

                <!-- Navigation -->
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="#inicio"
                        class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Inicio</a>
                    <a href="#funciones"
                        class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Funciones</a>
                    <a href="#como-funciona"
                        class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Cómo
                        Funciona</a>
                    <a href="#roles"
                        class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Roles</a>
                </nav>

                <!-- CTA Button -->
                <a href="{{ route('login') }}"
                    class="px-6 py-2.5 bg-[#1A202C] hover:bg-[#2D3748] text-white text-sm font-semibold rounded-lg transition-all shadow-sm">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="relative min-h-screen flex items-center pt-[72px] overflow-hidden">
        <!-- Subtle background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute top-20 right-0 w-[600px] h-[600px] bg-slate-50 rounded-full -translate-x-1/3 opacity-60">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-slate-50 rounded-full translate-y-1/2 -translate-x-1/2 opacity-40">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-16 lg:gap-20 items-center">
                <!-- Left Content -->
                <div class="space-y-8 opacity-0 animate-fadeInUp">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-full">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-xs font-semibold text-emerald-700">Sistema Activo · v1.0</span>
                    </div>

                    <div class="space-y-5">
                        <h1
                            class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#1A202C] leading-[1.1] tracking-tight">
                            Gestión inteligente de
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-slate-500 to-slate-400">reportes
                                de daños</span>
                        </h1>
                        <p class="text-lg text-slate-500 leading-relaxed max-w-lg">
                            SIGERD centraliza el reporte, seguimiento y resolución de incidentes en infraestructura.
                            Desde la detección hasta el cierre, todo documentado.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}"
                            class="px-8 py-3.5 bg-[#1A202C] hover:bg-[#2D3748] text-white text-sm font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 inline-flex items-center gap-2">
                            Acceder al Sistema
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#funciones"
                            class="px-8 py-3.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all">
                            Explorar Funciones
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-4 border-t border-slate-100">
                        <div>
                            <div class="text-2xl font-extrabold text-[#1A202C]">100%</div>
                            <div class="text-xs text-slate-400 font-medium mt-1">Trazabilidad</div>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold text-[#1A202C]">3 Roles</div>
                            <div class="text-xs text-slate-400 font-medium mt-1">Especializados</div>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold text-[#1A202C]">24/7</div>
                            <div class="text-xs text-slate-400 font-medium mt-1">Disponibilidad</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Dashboard Preview -->
                <div class="relative opacity-0 animate-fadeInUp delay-200">
                    <div class="animate-float">
                        <div class="bg-[#1A202C] rounded-2xl p-6 shadow-2xl">
                            <!-- Window controls -->
                            <div class="flex items-center gap-2 mb-5">
                                <div class="w-3 h-3 bg-[#FF5F57] rounded-full"></div>
                                <div class="w-3 h-3 bg-[#FFBD2E] rounded-full"></div>
                                <div class="w-3 h-3 bg-[#28C840] rounded-full"></div>
                                <div class="ml-auto text-[10px] text-white/30 font-mono">sigerd.app/dashboard</div>
                            </div>

                            <!-- Mock Dashboard -->
                            <div class="bg-white rounded-xl p-5 space-y-4">
                                <!-- Stats row -->
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <div class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">
                                            Reportes</div>
                                        <div class="text-2xl font-bold text-[#1A202C] mt-1">42</div>
                                        <div class="text-[10px] text-emerald-500 font-semibold mt-1">↑ 12% vs ayer</div>
                                    </div>
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <div class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">
                                            Tareas</div>
                                        <div class="text-2xl font-bold text-[#1A202C] mt-1">28</div>
                                        <div class="text-[10px] text-blue-500 font-semibold mt-1">18 activas</div>
                                    </div>
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <div class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">
                                            Resueltos</div>
                                        <div class="text-2xl font-bold text-[#1A202C] mt-1">93%</div>
                                        <div class="text-[10px] text-emerald-500 font-semibold mt-1">Meta: 90%</div>
                                    </div>
                                </div>

                                <!-- Mock table -->
                                <div class="border border-slate-100 rounded-lg overflow-hidden">
                                    <div
                                        class="bg-slate-50 px-4 py-2 text-[10px] text-slate-400 font-bold uppercase tracking-wider flex justify-between">
                                        <span>Incidente reciente</span>
                                        <span>Estado</span>
                                    </div>
                                    <div class="px-4 py-2.5 flex justify-between items-center border-b border-slate-50">
                                        <span class="text-xs text-slate-700 font-medium">Falla eléctrica - Aula 3</span>
                                        <span
                                            class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">PENDIENTE</span>
                                    </div>
                                    <div class="px-4 py-2.5 flex justify-between items-center border-b border-slate-50">
                                        <span class="text-xs text-slate-700 font-medium">Tubería rota - Baño 2</span>
                                        <span
                                            class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">ASIGNADO</span>
                                    </div>
                                    <div class="px-4 py-2.5 flex justify-between items-center">
                                        <span class="text-xs text-slate-700 font-medium">Puerta dañada - Lab 5</span>
                                        <span
                                            class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">RESUELTO</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="funciones" class="py-24 lg:py-32 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="text-center mb-16 opacity-0 animate-fadeInUp">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-widest mb-3">Funcionalidades</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-[#1A202C] tracking-tight">Todo lo que necesitas para
                    gestionar incidentes</h2>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto">SIGERD cubre el ciclo completo de un reporte de daño:
                    desde la creación hasta su resolución documentada.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-100 bg-white p-7 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-[#1A202C] mb-2">Reportes de Incidentes</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Los instructores crean reportes con descripción,
                        ubicación y evidencia fotográfica de cada daño detectado.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-200 bg-white p-7 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-[#1A202C] mb-2">Gestión de Tareas</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">El administrador convierte reportes en tareas y
                        las asigna a trabajadores con prioridad y fecha límite.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-300 bg-white p-7 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-[#1A202C] mb-2">Notificaciones</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Alertas en tiempo real cuando se crean reportes,
                        asignan tareas o se completan trabajos.</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-400 bg-white p-7 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-[#1A202C] mb-2">Evidencia Visual</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Captura fotográfica del antes y después de cada
                        incidente para documentación completa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section id="como-funciona" class="py-24 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-widest mb-3">Proceso</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-[#1A202C] tracking-tight">¿Cómo funciona SIGERD?
                </h2>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Un flujo simple y eficiente que conecta a todos los
                    actores del proceso.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="relative text-center group">
                    <div
                        class="w-16 h-16 bg-[#1A202C] rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-extrabold group-hover:scale-110 transition-transform shadow-lg">
                        1
                    </div>
                    <h4 class="text-xl font-bold text-[#1A202C] mb-3">Reportar</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">El instructor detecta un daño y crea un reporte
                        con descripción, ubicación y fotografías de evidencia.</p>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-8 right-0 translate-x-1/2">
                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center group">
                    <div
                        class="w-16 h-16 bg-[#1A202C] rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-extrabold group-hover:scale-110 transition-transform shadow-lg">
                        2
                    </div>
                    <h4 class="text-xl font-bold text-[#1A202C] mb-3">Asignar</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">El administrador revisa el reporte, lo convierte
                        en tarea y lo asigna al trabajador adecuado con prioridad.</p>
                    <!-- Arrow -->
                    <div class="hidden md:block absolute top-8 right-0 translate-x-1/2">
                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="text-center group">
                    <div
                        class="w-16 h-16 bg-[#1A202C] rounded-2xl flex items-center justify-center mx-auto mb-6 text-white text-2xl font-extrabold group-hover:scale-110 transition-transform shadow-lg">
                        3
                    </div>
                    <h4 class="text-xl font-bold text-[#1A202C] mb-3">Resolver</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">El trabajador ejecuta la reparación, sube
                        evidencia de resolución y el administrador puede cerrar el caso.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-24 lg:py-32 bg-[#1A202C]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold text-white/40 uppercase tracking-widest mb-3">Usuarios</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">Tres roles, un objetivo</h2>
                <p class="text-white/50 mt-4 max-w-2xl mx-auto">Cada usuario tiene herramientas específicas diseñadas
                    para su responsabilidad dentro del sistema.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Admin -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/10 transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform ring-1 ring-white/20">
                        <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Administrador</h4>
                    <p class="text-white/50 text-sm leading-relaxed mb-6">Control total del sistema. Gestiona usuarios,
                        asigna tareas, revisa reportes y supervisa la resolución de incidentes.</p>
                    <ul class="space-y-2">
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Dashboard de métricas
                        </li>
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Gestión de usuarios y roles
                        </li>
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Conversión de reportes a tareas
                        </li>
                    </ul>
                </div>

                <!-- Instructor -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/10 transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform ring-1 ring-white/20">
                        <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Instructor</h4>
                    <p class="text-white/50 text-sm leading-relaxed mb-6">Primer respondedor. Detecta daños en campo y
                        genera reportes detallados con evidencia para activar el proceso.</p>
                    <ul class="space-y-2">
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Creación de reportes
                        </li>
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Carga de evidencia fotográfica
                        </li>
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Seguimiento de estado
                        </li>
                    </ul>
                </div>

                <!-- Worker -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:bg-white/10 transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform ring-1 ring-white/20">
                        <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Trabajador</h4>
                    <p class="text-white/50 text-sm leading-relaxed mb-6">Personal técnico que ejecuta las reparaciones
                        asignadas y documenta la resolución con evidencia.</p>
                    <ul class="space-y-2">
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Ejecución de tareas
                        </li>
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Evidencia de resolución
                        </li>
                        <li class="text-xs text-white/40 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Actualización de progreso
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 lg:py-32 bg-white">
        <div class="max-w-3xl mx-auto px-6 lg:px-12 text-center">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-[#1A202C] tracking-tight mb-4">¿Listo para empezar?</h2>
            <p class="text-slate-500 text-lg mb-8">Accede al sistema y comienza a gestionar los reportes de daños de tu
                institución de manera eficiente.</p>
            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 px-10 py-4 bg-[#1A202C] hover:bg-[#2D3748] text-white text-sm font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Acceder a SIGERD
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-50 border-t border-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo/logo.webp') }}" alt="SIGERD" class="h-9 w-auto">
                </div>
                <p class="text-sm text-slate-400 text-center">
                    &copy; {{ date('Y') }} SIGERD · Sistema de Gestión de Reportes de Daños · Todos los derechos
                    reservados
                </p>
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </footer>

</body>

</html>