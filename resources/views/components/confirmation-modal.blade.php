{{-- Global Confirmation Modal - Include once in the main layout --}}
<div x-data="confirmationModal()" x-cloak @confirm-action.window="openModal($event.detail)">

    {{-- Overlay --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[200]" @click="close()">
    </div>

    {{-- Modal --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="fixed inset-0 z-[201] flex items-center justify-center p-4">

        <div class="bg-white dark:bg-[#242526] rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-200 dark:border-[#3A3B3C]"
            @click.stop>

            {{-- Header --}}
            <div class="px-6 pt-6 pb-2">
                {{-- Icon --}}
                <div class="mx-auto w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                    :class="variant === 'danger' ? 'bg-red-50 dark:bg-red-900/20' : 'bg-amber-50 dark:bg-amber-900/20'">
                    {{-- Danger icon --}}
                    <template x-if="variant === 'danger'">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </template>
                    {{-- Warning icon --}}
                    <template x-if="variant === 'warning'">
                        <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </template>
                </div>

                {{-- Title --}}
                <h3 class="text-lg font-bold text-slate-900 dark:text-white text-center" x-text="title"></h3>
            </div>

            {{-- Body --}}
            <div class="px-6 py-3">
                <p class="text-sm text-slate-500 dark:text-[#B0B3B8] text-center leading-relaxed" x-text="message"></p>
            </div>

            {{-- Actions --}}
            <div class="px-6 pb-6 pt-3 flex items-center gap-3">
                <button @click="close()"
                    class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-[#3A3B3C] dark:hover:bg-[#4E4F50] text-slate-700 dark:text-gray-200 font-semibold rounded-xl transition-colors text-sm">
                    Cancelar
                </button>
                <button @click="confirm()"
                    class="flex-1 px-4 py-2.5 font-semibold rounded-xl transition-colors text-sm text-white"
                    :class="variant === 'danger' ? 'bg-red-500 hover:bg-red-600' : 'bg-amber-500 hover:bg-amber-600'">
                    <span x-text="confirmText"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmationModal() {
        return {
            open: false,
            title: '',
            message: '',
            variant: 'danger',
            confirmText: 'Confirmar',
            formId: null,
            callback: null,

            openModal(detail) {
                this.title = detail.title || '¿Estás seguro?';
                this.message = detail.message || 'Esta acción no se puede deshacer.';
                this.variant = detail.variant || 'danger';
                this.confirmText = detail.confirmText || 'Eliminar';
                this.formId = detail.formId || null;
                this.callback = detail.callback || null;
                this.open = true;
            },

            close() {
                this.open = false;
            },

            confirm() {
                if (this.formId) {
                    const form = document.getElementById(this.formId);
                    if (form) form.submit();
                }
                if (this.callback && typeof this.callback === 'function') {
                    this.callback();
                }
                this.open = false;
            }
        }
    }
</script>