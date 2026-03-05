<!-- Modal para Editar Usuario -->
<div id="editUserModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"
            onclick="closeModal('editUserModal')"></div>

        <!-- Modal Panel -->
        <div
            class="inline-block align-bottom bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-white/20 dark:border-gray-700">
            <div class="p-8">
                <!-- Header del Modal -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-[#1A202C] dark:bg-gray-700 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 !text-white !stroke-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white"
                                id="modal-title">Editar
                                Usuario</h3>
                            <p class="text-gray-600 dark:text-gray-300 dark:text-gray-400 mt-1">Actualiza la
                                información del usuario</p>
                        </div>
                    </div>
                    <button onclick="closeModal('editUserModal')"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editUserForm" method="POST" action="" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Validation Errors Banner --}}
                    @if ($errors->any() && old('_method') == 'PUT')
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Por favor corrige
                                        los siguientes errores:</h3>
                                    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Foto de perfil -->
                    <div
                        class="space-y-4 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-gray-50 dark:bg-[#1A202C]">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Foto
                            de
                            Perfil</label>
                        <div class="flex items-start space-x-6">
                            <div class="shrink-0">
                                <div id="editImageContainer"
                                    class="h-24 w-24 rounded-2xl bg-[#1A202C] dark:bg-gray-700 flex items-center justify-center text-white font-bold text-lg shadow-lg ring-4 ring-white/50 dark:ring-gray-700/50 overflow-hidden">
                                    <span id="editInitialsPlaceholder">?</span>
                                    <img id="editPreviewImg" class="h-full w-full object-cover hidden" alt="Preview">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" id="edit_profile_photo" name="profile_photo" accept="image/*"
                                        class="hidden" onchange="previewEditUserImage(this)">
                                    <label for="edit_profile_photo"
                                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-[#242526] dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl font-medium text-gray-700 dark:text-gray-200 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 cursor-pointer transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Cambiar foto
                                    </label>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-[#B0B3B8] dark:text-gray-400">Dejar en
                                    blanco para mantener la imagen actual. JPG,
                                    PNG, GIF hasta 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="edit_user_name"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Nombre
                                Completo *</label>
                            <input id="edit_user_name" name="name" type="text" value="{{ old('name') }}" required
                                oninput="updateEditUserInitials(this.value)"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                placeholder="Nombre completo">
                        </div>
                        <div class="space-y-2">
                            <label for="edit_user_email"
                                class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Correo
                                Electrónico *</label>
                            <input id="edit_user_email" name="email" type="email" value="{{ old('email') }}" required
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm"
                                placeholder="usuario@ejemplo.com">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="edit_user_role"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-200 dark:text-gray-300">Rol
                            del
                            Usuario *</label>
                        <select id="edit_user_role" name="role" required
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-[#242526] dark:bg-gray-700 text-gray-900 dark:text-gray-100 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-200 shadow-sm">
                            <option value="">Selecciona un rol</option>
                            @foreach (['administrador', 'instructor', 'trabajador'] as $r)
                                <option value="{{ $r }}">
                                    {{ ucfirst($r) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <button type="button" onclick="closeModal('editUserModal')"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-white dark:bg-[#242526] dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-[#3A3B3C] dark:hover:bg-gray-600 rounded-xl font-semibold transition-all shadow-sm">Cancelar</button>
                        <button type="submit"
                            class="px-6 py-3 bg-[#1A202C] hover:bg-[#2D3748] text-white font-semibold rounded-xl transition-all shadow-lg transform hover:scale-105">Actualizar
                            Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewEditUserImage(input) {
            const preview = document.getElementById('editPreviewImg');
            const placeholder = document.getElementById('editInitialsPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        function updateEditUserInitials(name) {
            const placeholder = document.getElementById('editInitialsPlaceholder');
            const preview = document.getElementById('editPreviewImg');

            if (preview && preview.classList.contains('hidden')) {
                if (name.trim()) {
                    const names = name.trim().split(' ');
                    let initials = '';
                    names.forEach(n => {
                        if (n) initials += n.charAt(0).toUpperCase();
                    });
                    placeholder.textContent = initials.substring(0, 2) || '?';
                } else {
                    placeholder.textContent = '?';
                }
            }
        }
    </script>
</div>