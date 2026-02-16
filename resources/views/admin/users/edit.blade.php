<x-app-layout>
    {{-- Page header ------------------------------------------------}}
    <x-slot name="header">
        <div class="flex items-center gap-3">
            {{-- Icono opcional --}}
            <svg class="w-6 h-6 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                {{ __('Editar Usuario') }}
            </h2>
        </div>
    </x-slot>

    {{-- Content area -----------------------------------------------}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Card con glassmorphism --}}
            <div
                class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/30 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf @method('PUT')

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" class="text-gray-700 dark:text-gray-200" />
                            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required
                                autofocus autocomplete="name" class="mt-2 w-full rounded-lg border-gray-300 dark:border-gray-600
                                                 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200
                                                 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Correo electrónico')"
                                class="text-gray-700 dark:text-gray-200" />
                            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)"
                                required autocomplete="username" class="mt-2 w-full rounded-lg border-gray-300 dark:border-gray-600
                                                 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200
                                                 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Profile photo --}}
                        <div>
                            <x-input-label for="profile_photo" :value="__('Foto de perfil')"
                                class="text-gray-700 dark:text-gray-200" />
                            <div class="mt-2 flex items-center gap-5">
                                @if ($user->hasProfilePhoto())
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Avatar"
                                        class="h-20 w-20 rounded-full object-cover ring-4 ring-white dark:ring-gray-700 shadow-md">
                                @else
                                    <span
                                        class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                @endif
                                <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="block w-full text-sm text-gray-600 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-indigo-50 dark:file:bg-gray-700
                                              file:text-indigo-700 dark:file:text-indigo-300
                                              hover:file:bg-indigo-100 dark:hover:file:bg-gray-600
                                              transition" />
                            </div>
                            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                        </div>

                        {{-- Role --}}
                        <div>
                            <x-input-label for="role" :value="__('Rol')" class="text-gray-700 dark:text-gray-200" />
                            <select id="role" name="role" class="mt-2 w-full rounded-lg border-gray-300 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200
                                           focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" @selected($user->role === $role)>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end gap-3 pt-4">
                            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-semibold
                                      bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                      hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button
                                class="!bg-indigo-600 hover:!bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800">
                                {{ __('Guardar cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>