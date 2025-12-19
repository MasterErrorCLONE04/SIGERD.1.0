<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Iniciar Sesión</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .float-animation {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes slide-in-right {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            .slide-in {
                animation: slide-in-right 0.8s ease-out;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center">
                
                {{-- Panel Izquierdo - Información/Branding --}}
                <div class="hidden lg:flex flex-col justify-center space-y-8 p-12">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-3 bg-white/60 backdrop-blur-sm px-6 py-3 rounded-2xl shadow-lg border border-white">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">SIGERD</h1>
                                <p class="text-sm text-gray-600">Sistema de Gestión de Reportes</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h2 class="text-4xl font-bold text-gray-800 leading-tight">
                                Gestiona tus <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">reportes</span> de manera eficiente
                            </h2>
                            <p class="text-lg text-gray-600">
                                Plataforma integral para el seguimiento y gestión de incidentes y tareas de mantenimiento.
                            </p>
                        </div>
                    </div>

                    {{-- Características --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm p-4 rounded-xl border border-white">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Gestión en Tiempo Real</h3>
                                <p class="text-sm text-gray-600">Seguimiento instantáneo de todas las tareas</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm p-4 rounded-xl border border-white">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Notificaciones Inteligentes</h3>
                                <p class="text-sm text-gray-600">Mantente informado de cada actualización</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm p-4 rounded-xl border border-white">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Seguro y Confiable</h3>
                                <p class="text-sm text-gray-600">Tu información siempre protegida</p>
                            </div>
                        </div>
                    </div>

                    {{-- Ilustración decorativa --}}
                    <div class="relative">
                        <div class="float-animation">
                            <svg class="w-64 h-64 mx-auto opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Panel Derecho - Formulario de Login --}}
                <div class="w-full max-w-md mx-auto slide-in">
                    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white p-8 lg:p-10">
                        {{ $slot }}
                    </div>

                    <p class="mt-6 text-sm text-gray-600 text-center">
                        <span class="font-medium">SIGERD</span> © {{ date('Y') }} - Todos los derechos reservados
                    </p>
                </div>

            </div>
        </div>
    </body>
</html>
