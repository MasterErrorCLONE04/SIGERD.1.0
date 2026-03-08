<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Left Column - Form --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-between bg-white dark:bg-[#18191A] min-h-screen relative">

            {{-- Logo Top-Left --}}
            <div class="pt-8 lg:pt-10 px-8 lg:px-16">
                <div class="w-full max-w-sm mx-auto">
                    <a href="/" class="inline-flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('logo/logo.webp') }}" alt="SIGERD Logo" class="h-14 w-auto">
                    </a>
                </div>
            </div>

            {{-- Form Center --}}
            <div class="flex-1 flex items-center justify-center px-8 lg:px-16">
                <div class="w-full max-w-sm">

                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Recuperar
                        contraseña</h2>
                    <p class="text-sm text-slate-500 dark:text-[#B0B3B8] mb-8 font-medium leading-relaxed">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    {{-- Session Status --}}
                    <x-auth-session-status
                        class="mb-6 text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-4 py-3"
                        :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300">Correo
                                Electrónico</label>
                            <input id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full px-4 py-3 bg-white dark:bg-[#242526] border border-slate-200 dark:border-[#3A3B3C] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10 focus:border-slate-400 dark:focus:border-[#4E4F50] transition-all text-sm font-medium"
                                placeholder="usuario@ejemplo.com" type="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        {{-- Submit --}}
                        <button
                            class="w-full py-3 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white font-semibold rounded-lg transition-all text-sm mt-2 shadow-sm"
                            type="submit">
                            Enviar enlace de recuperación
                        </button>
                    </form>

                    {{-- Back to login --}}
                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-slate-500 dark:text-[#B0B3B8] hover:text-slate-700 dark:hover:text-white transition-colors inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-8 lg:px-16 pb-8 lg:pb-10">
                <div class="w-full max-w-sm mx-auto">
                    <p class="text-xs text-slate-400 dark:text-[#9CA3AF] text-center leading-relaxed">
                        Al continuar, aceptas los términos de uso y la política de privacidad de SIGERD.
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Column - Brand --}}
        <div class="hidden lg:flex w-1/2 bg-[#1A202C] dark:bg-[#242526] flex-col relative overflow-hidden">

            {{-- Subtle background pattern --}}
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-white rounded-full translate-y-1/2 -translate-x-1/2">
                </div>
            </div>

            <div class="flex-1 flex flex-col justify-center items-center px-16 relative z-10">
                <div class="max-w-md">
                    {{-- Icon --}}
                    <div class="mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center ring-1 ring-white/20">
                            <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-3xl font-bold text-white mb-4">¿Olvidaste tu contraseña?</h3>
                    <p class="text-white/60 text-lg leading-relaxed mb-8">
                        No te preocupes, te enviaremos las instrucciones para restablecerla. Solo necesitas el correo
                        asociado a tu cuenta.
                    </p>

                    {{-- Steps --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white/70 text-sm font-bold flex-shrink-0">
                                1</div>
                            <p class="text-white/50 text-sm">Ingresa tu correo electrónico</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white/70 text-sm font-bold flex-shrink-0">
                                2</div>
                            <p class="text-white/50 text-sm">Revisa tu bandeja de entrada</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white/70 text-sm font-bold flex-shrink-0">
                                3</div>
                            <p class="text-white/50 text-sm">Crea una nueva contraseña segura</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom --}}
            <div class="p-8 text-center relative z-10">
                <p class="text-white/30 text-xs font-medium tracking-wider uppercase">
                    © {{ date('Y') }} SIGERD · Todos los derechos reservados
                </p>
            </div>
        </div>

    </div>
</x-guest-layout>