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

                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Bienvenido de
                        vuelta</h2>
                    <p class="text-sm text-slate-500 dark:text-[#B0B3B8] mb-8 font-medium">Inicia sesión en tu cuenta
                    </p>

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300">Correo
                                Electrónico</label>
                            <input name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full px-4 py-3 bg-white dark:bg-[#242526] border border-slate-200 dark:border-[#3A3B3C] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10 focus:border-slate-400 dark:focus:border-[#4E4F50] transition-all text-sm font-medium"
                                placeholder="usuario@ejemplo.com" type="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label
                                class="block text-sm font-semibold text-slate-700 dark:text-gray-300">Contraseña</label>
                            <div class="relative" x-data="{ showPassword: false }">
                                <input name="password" required
                                    class="block w-full px-4 py-3 pr-12 bg-white dark:bg-[#242526] border border-slate-200 dark:border-[#3A3B3C] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10 focus:border-slate-400 dark:focus:border-[#4E4F50] transition-all text-sm font-medium"
                                    placeholder="••••••••" :type="showPassword ? 'text' : 'password'" />
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-gray-300 transition-colors">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="text-right">
                                    <a class="text-sm font-medium text-slate-500 dark:text-[#B0B3B8] hover:text-slate-700 dark:hover:text-white transition-colors"
                                        href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                                </div>
                            @endif
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        {{-- Submit --}}
                        <button
                            class="w-full py-3 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white font-semibold rounded-lg transition-all text-sm mt-2 shadow-sm"
                            type="submit">
                            Iniciar Sesión
                        </button>
                    </form>
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

        {{-- Right Column - Brand/Testimonial --}}
        <div class="hidden lg:flex w-1/2 bg-[#1A202C] dark:bg-[#242526] flex-col relative overflow-hidden">

            {{-- Subtle background pattern --}}
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-white rounded-full translate-y-1/2 -translate-x-1/2">
                </div>
            </div>

            {{-- Top area with dark visual --}}
            <div class="flex-1 flex flex-col justify-center items-center px-16 relative z-10">


                {{-- Quote/Testimonial --}}
                <div class="max-w-md">
                    {{-- Quote mark --}}
                    <div class="mb-6">
                        <svg class="w-10 h-10 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H0z" />
                        </svg>
                    </div>

                    <div class="min-h-[180px] flex items-start" x-data="{
                        phrases: [
                            'SIGERD ha transformado la forma en que gestionamos el mantenimiento y los reportes de daños.',
                            'Una plataforma que simplifica el seguimiento de incidencias en tiempo real.',
                            'Gestión eficiente de tareas y asignaciones para todo el equipo de trabajo.',
                            'Control total sobre el estado de cada reporte, desde su creación hasta su resolución.',
                            'La herramienta ideal para coordinar el mantenimiento de nuestras instalaciones.'
                        ],
                        currentPhrase: 0,
                        displayText: '',
                        charIndex: 0,
                        isDeleting: false,
                        typeSpeed: 35,
                        deleteSpeed: 20,
                        pauseEnd: 2500,
                        pauseStart: 500,
                        init() {
                            this.type();
                        },
                        type() {
                            const current = this.phrases[this.currentPhrase];
                            
                            if (!this.isDeleting && this.charIndex <= current.length) {
                                this.displayText = current.substring(0, this.charIndex);
                                this.charIndex++;
                                if (this.charIndex > current.length) {
                                    setTimeout(() => { this.isDeleting = true; this.type(); }, this.pauseEnd);
                                } else {
                                    setTimeout(() => this.type(), this.typeSpeed);
                                }
                            } else if (this.isDeleting && this.charIndex >= 0) {
                                this.displayText = current.substring(0, this.charIndex);
                                this.charIndex--;
                                if (this.charIndex < 0) {
                                    this.isDeleting = false;
                                    this.currentPhrase = (this.currentPhrase + 1) % this.phrases.length;
                                    this.charIndex = 0;
                                    setTimeout(() => this.type(), this.pauseStart);
                                } else {
                                    setTimeout(() => this.type(), this.deleteSpeed);
                                }
                            }
                        }
                    }">
                        <p class="text-2xl lg:text-3xl font-semibold text-white leading-relaxed mb-2">
                            <span x-text="displayText"></span><span
                                class="inline-block w-[3px] h-[1.2em] bg-white/60 ml-0.5 align-middle animate-pulse"></span>
                        </p>
                    </div>


                    {{-- Closing quote mark --}}
                    <div class="mb-8 flex justify-end">
                        <svg class="w-10 h-10 text-white/20 transform rotate-180" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H0z" />
                        </svg>
                    </div>

                    {{-- Author --}}
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white font-bold text-lg ring-2 ring-white/20">
                            S
                        </div>
                        <div>
                            <div class="text-white font-semibold text-sm">SIGERD</div>
                            <div class="text-white/50 text-sm">Sistema de Gestión de Reportes de Daños</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom subtle text --}}
            <div class="p-8 text-center relative z-10">
                <p class="text-white/30 text-xs font-medium tracking-wider uppercase">
                    © {{ date('Y') }} SIGERD · Todos los derechos reservados
                </p>
            </div>
        </div>

    </div>
</x-guest-layout>