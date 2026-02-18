<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGERD - Enterprise Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy-dark: #0F2742;
            --blue-corp: #1E3A5F;
            --blue-bright: #2F5DA8;
            --bg-main: #F4F6F8;
            --bg-secondary: #E9EDF2;
            --border-soft: #DCE3EA;
            --text-title: #0B1F33;
            --text-descr: #4A5A6A;
            --text-label: #7A8A9A;
            --metric-blue: #2D6CDF;
            --status-blue: #3B82F6;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-descr);
            margin: 0;
            padding: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .btn-primary {
            background-color: var(--navy-dark);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--blue-corp);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15, 39, 66, 0.2);
        }

        .nav-link {
            color: var(--text-descr);
            font-weight: 500;
            transition: color 0.2s ease;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
        }

        .nav-link:hover {
            color: var(--navy-dark);
        }

        /* Carousel Styles */
        .carousel-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 1.5rem;
            padding-bottom: 2rem;
            scrollbar-width: none;
        }

        .carousel-container::-webkit-scrollbar {
            display: none;
        }

        .carousel-item {
            flex: 0 0 calc(33.333% - 1rem);
            scroll-snap-align: start;
        }

        @media (max-width: 1024px) {
            .carousel-item {
                flex: 0 0 calc(50% - 0.75rem);
            }
        }

        @media (max-width: 640px) {
            .carousel-item {
                flex: 0 0 calc(100%);
            }
        }
    </style>
</head>

<body class="antialiased">

    <!-- Navbar -->
    <header class="bg-white/90 backdrop-blur-md fixed top-0 w-full z-50 border-b border-[#E9EDF2]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex justify-between items-center py-5">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#0F2742] rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-[#0B1F33] tracking-tight">SIGERD</h1>
                        <p class="text-[10px] text-[#7A8A9A] font-medium uppercase tracking-[0.2em]">Enterprise
                            Management</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden lg:flex items-center gap-10">
                    <a href="#soluciones" class="nav-link">Soluciones</a>
                    <a href="#funciones" class="nav-link">Funciones</a>
                    <a href="#beneficios" class="nav-link">Beneficios</a>
                    <a href="#roles" class="nav-link">Roles</a>
                </nav>

                <!-- CTA Button -->
                <div class="flex items-center">
                    <a href="{{ route('login') }}"
                        class="px-8 py-3 bg-[#0F2742] text-white text-[11px] font-bold rounded shadow-sm hover:bg-[#1E3A5F] transition-all uppercase tracking-[0.2em]">
                        Acceso al Sistema
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main id="soluciones" class="relative pt-48 pb-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <!-- Left Content -->
                <div class="space-y-10 opacity-0 animate-fadeInUp">
                    <div
                        class="inline-flex items-center gap-3 px-3 py-1 bg-white border border-[#DCE3EA] rounded shadow-sm">
                        <span class="w-2 h-2 bg-[#3B82F6] rounded-full"></span>
                        <span class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest">Protocolo v4.0
                            Active</span>
                    </div>

                    <div class="space-y-4">
                        <h1 class="text-5xl lg:text-7xl font-bold text-[#0B1F33] leading-[1.05] tracking-tight">
                            Gestión Crítica de <br>
                            <span class="text-[#7A8A9A] font-light italic">Infraestructura</span>
                        </h1>
                        <p class="text-lg text-[#4A5A6A] leading-relaxed max-w-xl">
                            Digitalice la supervisión de activos y garantice la trazabilidad total de cada incidente
                            estructural bajo estándares corporativos rigurosos.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('login') }}"
                            class="px-10 py-4 bg-[#0F2742] text-white text-sm font-bold rounded shadow-xl hover:bg-[#1E3A5F] transition-all uppercase tracking-widest">
                            Empezar Sesión
                        </a>
                        <a href="#funciones"
                            class="px-10 py-4 bg-white border border-[#DCE3EA] text-[#4A5A6A] text-sm font-bold rounded hover:bg-[#F4F6F8] transition-all uppercase tracking-widest">
                            Ver Funciones
                        </a>
                    </div>

                    <div class="h-px bg-[#DCE3EA] w-full"></div>

                    <div class="grid grid-cols-3 gap-12">
                        <div>
                            <div class="text-3xl font-bold text-[#0B1F33]">99.9%</div>
                            <div class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-[0.2em] mt-2">Uptime
                                Core</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-[#0B1F33]">100%</div>
                            <div class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-[0.2em] mt-2">
                                Trazabilidad</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-[#0B1F33]">Audit</div>
                            <div class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-[0.2em] mt-2">Certified
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content (Keep the mockup style) -->
                <div class="relative opacity-0 animate-fadeInUp" style="animation-delay: 0.3s;">
                    <div class="bg-[#E9EDF2] rounded-[2.5rem] p-5 shadow-2xl border border-white">
                        <div class="bg-white rounded-[2rem] shadow-inner overflow-hidden border border-[#DCE3EA]">
                            <div class="bg-white px-8 py-5 border-b border-[#F4F6F8] flex justify-between items-center">
                                <div class="flex gap-2">
                                    <div class="w-2.5 h-2.5 bg-[#E9EDF2] rounded-full"></div>
                                    <div class="w-2.5 h-2.5 bg-[#E9EDF2] rounded-full"></div>
                                    <div class="w-2.5 h-2.5 bg-[#E9EDF2] rounded-full"></div>
                                </div>
                                <div class="text-[9px] font-bold text-[#7A8A9A] uppercase tracking-widest">
                                    HQ.Sigerd/Main-Terminal</div>
                                <div class="w-10"></div>
                            </div>
                            <div class="p-8 space-y-8">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="p-6 bg-white border border-[#F4F6F8] rounded-2xl shadow-sm">
                                        <div class="text-[9px] font-bold text-[#7A8A9A] uppercase tracking-widest mb-4">
                                            Pending Ops</div>
                                        <div class="text-5xl font-bold text-[#0B1F33]">42</div>
                                    </div>
                                    <div class="p-6 bg-white border border-[#F4F6F8] rounded-2xl shadow-sm relative">
                                        <div class="text-[9px] font-bold text-[#7A8A9A] uppercase tracking-widest mb-4">
                                            Risk Level</div>
                                        <div class="text-4xl font-bold text-[#2F5DA8] uppercase italic">Low</div>
                                        <div
                                            class="absolute -right-4 -top-4 p-4 bg-white rounded-xl shadow-xl border border-[#DCE3EA] flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-[#E9EDF2]">
                                                <svg class="w-6 h-6 text-[#3B82F6]" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[8px] font-bold text-[#7A8A9A] uppercase tracking-widest">
                                                    Efficiency</div>
                                                <div class="text-md font-bold text-[#0B1F33]">99.2%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Features Carousel Section -->
    <section id="funciones" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="mb-16">
                <h2 class="text-[10px] font-bold text-[#2D6CDF] uppercase tracking-[0.5em] mb-4">Core Ecosystem</h2>
                <h3 class="text-4xl font-bold text-[#0B1F33] tracking-tight">Capacidades del Sistema</h3>
            </div>

            <div class="carousel-container">
                <!-- Feature 1 -->
                <div
                    class="carousel-item bg-[#F4F6F8] p-10 rounded-2xl border border-[#DCE3EA] hover:border-[#1E3A5F] transition-all group">
                    <div
                        class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-8 shadow-sm group-hover:bg-[#1E3A5F] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-[#0B1F33] mb-4 uppercase tracking-tighter">Evidencia Visual</h4>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed">Documentación fotográfica de incidentes y
                        resoluciones con marca de agua y ubicación GPS.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="carousel-item bg-[#F4F6F8] p-10 rounded-2xl border border-[#DCE3EA] hover:border-[#1E3A5F] transition-all group">
                    <div
                        class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-8 shadow-sm group-hover:bg-[#1E3A5F] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-[#0B1F33] mb-4 uppercase tracking-tighter">Motor de Tareas</h4>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed">Asignación dinámica basada en disponibilidad
                        técnica y categorización automática de prioridad.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="carousel-item bg-[#F4F6F8] p-10 rounded-2xl border border-[#DCE3EA] hover:border-[#1E3A5F] transition-all group">
                    <div
                        class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-8 shadow-sm group-hover:bg-[#1E3A5F] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-[#0B1F33] mb-4 uppercase tracking-tighter">Alertas HQ</h4>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed">Notificaciones push inmediatas para responsables
                        ante incidentes etiquetados como 'Críticos'.</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="carousel-item bg-[#F4F6F8] p-10 rounded-2xl border border-[#DCE3EA] hover:border-[#1E3A5F] transition-all group">
                    <div
                        class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-8 shadow-sm group-hover:bg-[#1E3A5F] group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-[#0B1F33] mb-4 uppercase tracking-tighter">BI Analytics</h4>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed">Paneles estadísticos interactivos para la
                        optimización de tiempos de respuesta operativa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="beneficios" class="py-32 bg-[#F4F6F8]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">
            <h2 class="text-[10px] font-bold text-[#2D6CDF] uppercase tracking-[0.5em] mb-12">Valor Corporativo</h2>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="space-y-6">
                    <div class="text-4xl font-bold text-[#0B1F33]">85%</div>
                    <h5 class="text-xs font-bold uppercase tracking-widest text-[#7A8A9A]">Reducción de Riesgos</h5>
                    <p class="text-sm leading-relaxed text-[#4A5A6A]">Prevención activa mediante protocolos de
                        mantenimiento documentados en tiempo real.</p>
                </div>
                <div class="space-y-6">
                    <div class="text-4xl font-bold text-[#0B1F33]">100%</div>
                    <h5 class="text-xs font-bold uppercase tracking-widest text-[#7A8A9A]">Trazabilidad Total</h5>
                    <p class="text-sm leading-relaxed text-[#4A5A6A]">Historial inalterable de cada reporte, desde la
                        detección hasta la firma de cierre.</p>
                </div>
                <div class="space-y-6">
                    <div class="text-4xl font-bold text-[#0B1F33]">Certified</div>
                    <h5 class="text-xs font-bold uppercase tracking-widest text-[#7A8A9A]">Compliance Ops</h5>
                    <p class="text-sm leading-relaxed text-[#4A5A6A]">Alineación con normativas de seguridad industrial
                        y auditoría de procesos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-40 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">
            <h4 class="text-[10px] font-bold text-[#2D6CDF] uppercase tracking-[0.5em] mb-20">Arquitectura de Usuarios
            </h4>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Role: Admin -->
                <div class="p-12 border border-[#DCE3EA] rounded-3xl hover:shadow-2xl transition-all text-left group">
                    <div class="text-[#0F2742] mb-10 transform group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h5 class="text-2xl font-bold text-[#0B1F33] mb-6">Administrador</h5>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed mb-8">Punto de control central. Supervisa el flujo
                        global, asigna recursos y valida la resolución de incidentes críticos.</p>
                    <ul class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest space-y-3">
                        <li class="flex gap-2"><span>+</span> Full Analytics Dashboard</li>
                        <li class="flex gap-2"><span>+</span> Task Delegation HQ</li>
                        <li class="flex gap-2"><span>+</span> User & Role Mgmt</li>
                    </ul>
                </div>

                <!-- Role: Instructor -->
                <div
                    class="p-12 border border-[#DCE3EA] rounded-3xl hover:shadow-2xl transition-all text-left bg-[#F4F6F8]/50 group">
                    <div class="text-[#1E3A5F] mb-10 transform group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h5 class="text-2xl font-bold text-[#0B1F33] mb-6">Instructor</h5>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed mb-8">Monitor de campo primario. Responsable del
                        levantamiento de reportes iniciales y seguimiento de estado.</p>
                    <ul class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest space-y-3">
                        <li class="flex gap-2"><span>+</span> Mobile Incident Reporting</li>
                        <li class="flex gap-2"><span>+</span> Evidence Archiving</li>
                        <li class="flex gap-2"><span>+</span> Status Monitoring</li>
                    </ul>
                </div>

                <!-- Role: Worker -->
                <div class="p-12 border border-[#DCE3EA] rounded-3xl hover:shadow-2xl transition-all text-left group">
                    <div class="text-[#2F5DA8] mb-10 transform group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <h5 class="text-2xl font-bold text-[#0B1F33] mb-6">Trabajador</h5>
                    <p class="text-sm text-[#4A5A6A] leading-relaxed mb-8">Personal técnico. Ejecuta las tareas
                        asignadas y documenta el cierre técnico del incidente.</p>
                    <ul class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest space-y-3">
                        <li class="flex gap-2"><span>+</span> Task Execution logs</li>
                        <li class="flex gap-2"><span>+</span> Resolution Evidence</li>
                        <li class="flex gap-2"><span>+</span> Process Documentation</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white text-[#4A5A6A] py-24 px-6 lg:px-12 border-t border-[#E9EDF2]">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-4 gap-16 pb-16 border-b border-[#E9EDF2]">
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#0F2742] rounded flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-[#0B1F33]">SIGERD</span>
                </div>
                <p class="text-sm text-[#7A8A9A] max-w-sm">Sistema avanzado de gestión de infraestructuras para
                    organizaciones de alto nivel.</p>
            </div>

            <div class="space-y-6">
                <h6 class="text-[10px] font-bold text-[#0B1F33] uppercase tracking-[0.2em]">Sistema</h6>
                <ul class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest space-y-3">
                    <li><a href="#soluciones" class="hover:text-[#0F2742] transition-colors">Soluciones</a></li>
                    <li><a href="#funciones" class="hover:text-[#0F2742] transition-colors">Funciones</a></li>
                </ul>
            </div>

            <div class="space-y-6">
                <h6 class="text-[10px] font-bold text-[#0B1F33] uppercase tracking-[0.2em]">Soporte</h6>
                <ul class="text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest space-y-3">
                    <li><a href="#" class="hover:text-[#0F2742] transition-colors">Documentación</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-[#0F2742] transition-colors">Acceso</a></li>
                </ul>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto pt-10 flex flex-col md:flex-row justify-between items-center text-[10px] font-bold text-[#7A8A9A] uppercase tracking-widest gap-6">
            <p>&copy; {{ date('Y') }} SIGERD GLOBAL HQ.</p>
            <div class="flex gap-8">
                <span>Enterprise v4.0</span>
                <span class="text-[#0B1F33]">Certified Ops</span>
            </div>
        </div>
    </footer>

</body>

</html>