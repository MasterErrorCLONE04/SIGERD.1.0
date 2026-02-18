<x-guest-layout>
    <!-- Centered Card Wrapper -->
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

        <!-- The Card Itself -->
        <div
            class="w-full max-w-7xl bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row">

            {{-- Left Column (Features/Brand) --}}
            <div
                class="w-full lg:w-1/2 p-8 lg:p-16 flex flex-col justify-center bg-slate-50 dark:bg-slate-900/50 border-r border-slate-100 dark:border-slate-700/50">
                <div class="max-w-md mx-auto lg:mx-0">
                    <div
                        class="flex items-center space-x-3 mb-12 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 w-fit">
                        <div class="bg-[#1E3A8A] p-2.5 rounded-xl shadow-lg shadow-blue-900/20">
                            <span class="material-icons-round text-white text-2xl">description</span>
                        </div>
                        <div>
                            <h1
                                class="text-2xl font-bold text-[#1E3A8A] dark:text-blue-400 leading-none tracking-tight">
                                SIGERD</h1>
                            <p
                                class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold mt-1">
                                Sistema de Gestión</p>
                        </div>
                    </div>

                    <h2
                        class="text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white mb-6 leading-[1.15] tracking-tight">
                        Gestiona tus <span class="text-[#1E3A8A] dark:text-blue-400 relative">reportes<span
                                class="absolute bottom-1 left-0 w-full h-2 bg-blue-200/30 dark:bg-blue-900/30 -z-10 rounded-full"></span></span>
                        de manera eficiente
                    </h2>

                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-10 leading-relaxed font-medium">
                        Plataforma integral para el seguimiento y gestión de incidentes y tareas de mantenimiento para
                        entornos corporativos de alto nivel.
                    </p>

                    <div class="space-y-4">
                        <div
                            class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group cursor-default">
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                                <span
                                    class="material-icons-round text-[#1E3A8A] dark:text-blue-400 text-xl">speed</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white text-sm">Gestión en Tiempo Real</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Seguimiento
                                    instantáneo de todas las tareas.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group cursor-default">
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                                <span
                                    class="material-icons-round text-[#1E3A8A] dark:text-blue-400 text-xl">notifications_active</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white text-sm">Notificaciones Inteligentes
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Mantente
                                    informado de cada actualización.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 group cursor-default">
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                                <span
                                    class="material-icons-round text-[#1E3A8A] dark:text-blue-400 text-xl">verified_user</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white text-sm">Seguro y Confiable</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Tu información
                                    protegida bajo estándares bancarios.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column (Form) --}}
            <div
                class="w-full lg:w-1/2 p-8 lg:p-16 flex items-center justify-center relative overflow-hidden bg-white dark:bg-slate-800">
                <!-- Background Decoration -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#1E3A8A]/5 rounded-full blur-[100px]"></div>
                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-blue-400/10 rounded-full blur-[80px]"></div>

                <div class="w-full max-w-sm z-10 relative">
                    <div class="text-center mb-10">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl mb-6 shadow-inner ring-1 ring-slate-100 dark:ring-slate-700">
                            <span class="material-icons-round text-[#1E3A8A] dark:text-blue-400 text-4xl">person</span>
                        </div>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">¡Bienvenido!
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Ingresa tus credenciales para
                            continuar</p>
                    </div>

                    {{-- LARAVEL FORM --}}
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Correo
                                Electrónico</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span
                                        class="material-icons-round text-slate-400 text-xl group-focus-within:text-[#1E3A8A] transition-colors">alternate_email</span>
                                </div>
                                <input name="email" value="{{ old('email') }}" required autofocus
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/10 focus:border-[#1E3A8A] transition-all duration-200 font-medium sm:text-sm"
                                    placeholder="usuario@ejemplo.com" type="email" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span
                                        class="material-icons-round text-slate-400 text-xl group-focus-within:text-[#1E3A8A] transition-colors">lock_outline</span>
                                </div>
                                <input name="password" required
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/10 focus:border-[#1E3A8A] transition-all duration-200 font-medium sm:text-sm"
                                    placeholder="••••••••" type="password" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
                        </div>

                        {{-- Options --}}
                        <div class="flex items-center justify-between pt-2">
                            <label
                                class="flex items-center text-sm font-medium text-slate-600 dark:text-slate-400 cursor-pointer select-none group">
                                <input name="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-[#1E3A8A] focus:ring-[#1E3A8A] mr-2.5 bg-white dark:bg-slate-900 transition-colors cursor-pointer"
                                    type="checkbox" />
                                <span
                                    class="group-hover:text-slate-800 dark:group-hover:text-slate-300 transition-colors">Recordarme</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-[#1E3A8A] dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                    href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>

                        <button
                            class="w-full py-4 bg-[#0F2742] hover:bg-[#1E3A5F] text-white font-bold rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg shadow-[#0F2742]/30 hover:shadow-[#0F2742]/50 flex items-center justify-center space-x-2.5 text-sm sm:text-base mt-4 uppercase tracking-widest"
                            type="submit">
                            <span class="material-icons-round">login</span>
                            <span>Iniciar Sesión Segura</span>
                        </button>
                    </form>

                </div>

                <p
                    class="absolute bottom-6 text-center text-[10px] text-slate-400 dark:text-slate-600 uppercase tracking-[0.2em] font-bold opacity-70 hover:opacity-100 transition-opacity cursor-default">
                    SIGERD © {{ date('Y') }} - Todos los derechos reservados
                </p>
            </div>
        </div>

        <!-- Theme Toggle -->
        <button
            class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-white dark:bg-slate-800 shadow-xl border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-yellow-400 hover:scale-110 active:scale-95 transition-all duration-300 z-50 hover:text-[#1E3A8A] dark:hover:text-yellow-300"
            onclick="document.documentElement.classList.toggle('dark')">
            <span class="material-icons-round dark:hidden text-2xl">dark_mode</span>
            <span class="material-icons-round hidden dark:block text-2xl">light_mode</span>
        </button>
    </div>
</x-guest-layout>