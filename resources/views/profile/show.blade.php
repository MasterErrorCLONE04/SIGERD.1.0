<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <div
        class="py-8 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="relative">
                            @if($user->hasProfilePhoto())
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                    class="h-40 w-40 rounded-3xl object-cover shadow-xl ring-4 ring-white/50 dark:ring-gray-700/50">
                            @else
                                <div
                                    class="h-40 w-40 rounded-3xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-5xl shadow-xl ring-4 ring-white/50 dark:ring-gray-700/50">
                                    {{ $user->initials }}
                                </div>
                            @endif
                        </div>

                        <div class="text-center md:text-left flex-1">
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                            <p class="text-xl text-gray-600 dark:text-gray-400 mt-2">{{ $user->email }}</p>

                            <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-4">
                                <span class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg
                                    @if($user->role === 'administrador') 
                                        bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-purple-500/30
                                    @elseif($user->role === 'instructor')
                                        bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-blue-500/30
                                    @elseif($user->role === 'trabajador')
                                        bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-green-500/30
                                    @else
                                        bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-gray-500/30
                                    @endif">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                    {{ ucfirst($user->role) }}
                                </span>

                                <span
                                    class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 shadow-md border border-gray-100 dark:border-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Miembro desde {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Acciones -->
                <div
                    class="px-8 py-5 bg-gray-50/80 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700/50 flex justify-end gap-4 backdrop-blur-sm">
                    <a href="{{ route('profile.edit') }}"
                        class="px-6 py-2.5 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm transition-all focus:ring-2 focus:ring-gray-200 shadow-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Ir a Configuración
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>