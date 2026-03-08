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

                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Nueva contraseña
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-[#B0B3B8] mb-8 font-medium leading-relaxed">
                        Ingresa tu nueva contraseña para restablecer el acceso a tu cuenta.
                    </p>

                    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                        @csrf

                        {{-- Token --}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300">Correo
                                Electrónico</label>
                            <input id="email" name="email" value="{{ old('email', $request->email) }}" required
                                autofocus autocomplete="username"
                                class="block w-full px-4 py-3 bg-slate-50 dark:bg-[#242526] border border-slate-200 dark:border-[#3A3B3C] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10 focus:border-slate-400 dark:focus:border-[#4E4F50] transition-all text-sm font-medium"
                                placeholder="usuario@ejemplo.com" type="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300">Nueva
                                Contraseña</label>
                            <div class="relative" x-data="{ showPassword: false }">
                                <input id="password" name="password" required autocomplete="new-password"
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
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        {{-- Confirm Password --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-gray-300">Confirmar
                                Contraseña</label>
                            <input id="password_confirmation" name="password_confirmation" required
                                autocomplete="new-password"
                                class="block w-full px-4 py-3 bg-white dark:bg-[#242526] border border-slate-200 dark:border-[#3A3B3C] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10 focus:border-slate-400 dark:focus:border-[#4E4F50] transition-all text-sm font-medium"
                                placeholder="••••••••" type="password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>

                        {{-- Submit --}}
                        <button
                            class="w-full py-3 bg-[#1A202C] hover:bg-[#2D3748] dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-white font-semibold rounded-lg transition-all text-sm mt-2 shadow-sm"
                            type="submit">
                            Restablecer Contraseña
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
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-3xl font-bold text-white mb-4">Seguridad ante todo</h3>
                    <p class="text-white/60 text-lg leading-relaxed mb-8">
                        Tu nueva contraseña debe ser segura y diferente a las anteriores para proteger tu cuenta.
                    </p>

                    {{-- Tips --}}
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-white/40 text-sm">
                            <svg class="w-4 h-4 text-green-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mínimo 8 caracteres
                        </div>
                        <div class="flex items-center gap-3 text-white/40 text-sm">
                            <svg class="w-4 h-4 text-green-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Combina letras y números
                        </div>
                        <div class="flex items-center gap-3 text-white/40 text-sm">
                            <svg class="w-4 h-4 text-green-400/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Incluye caracteres especiales
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