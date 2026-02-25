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
                                    @if($user->role === 'administrador')
                                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @elseif($user->role === 'instructor')
                                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z" />
                                            <path
                                                d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z" />
                                            <path
                                                d="M4.462 19.462c.42-.419.753-.89 1-1.394.453.213.902.434 1.347.662a6.742 6.742 0 01-1.286 1.794.75.75 0 01-1.06-1.062z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M7.5 5.25A3.25 3.25 0 0110.75 2h2.5A3.25 3.25 0 0116.5 5.25V6h3.625c.621 0 1.125.504 1.125 1.125v2.413A1.5 1.5 0 0020.25 9.6h-16.5A1.5 1.5 0 002.75 9.538V7.125C2.75 6.504 3.254 6 3.875 6H7.5v-.75zm1.5 0V6h6v-.75a1.75 1.75 0 00-1.75-1.75h-2.5A1.75 1.75 0 009 5.25z"
                                                clip-rule="evenodd" />
                                            <path
                                                d="M2.75 11.25V17.5A2.25 2.25 0 005 19.75h14A2.25 2.25 0 0021 17.5v-6.25H2.75z" />
                                        </svg>
                                    @endif
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