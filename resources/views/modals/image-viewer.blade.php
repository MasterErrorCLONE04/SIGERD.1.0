{{-- Modal para ver imagen en grande --}}
<div id="imageModal"
    class="fixed inset-0 bg-black/95 backdrop-blur-xl z-[100] hidden items-center justify-center p-6 overflow-hidden"
    onclick="closeImageModal()">
    <div class="relative w-full h-full flex flex-col items-center justify-center overflow-hidden"
        onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="Imagen ampliada"
            class="max-w-full max-h-[75vh] rounded-[2rem] shadow-[0_0_100px_rgba(0,0,0,0.5)] object-contain transition-transform duration-300 transform scale-95 opacity-0"
            onload="this.classList.remove('scale-95', 'opacity-0'); this.classList.add('scale-100', 'opacity-100')">

        <button onclick="closeImageModal()"
            class="absolute top-4 right-4 text-white/40 hover:text-white transition-all duration-300 hover:scale-110 active:scale-90">
            <span class="material-symbols-outlined text-4xl">close</span>
        </button>

        {{-- Botón de descarga --}}
        <a id="downloadButton" href="" download
            class="mt-12 flex items-center gap-4 bg-white dark:bg-[#242526] text-indigo-900 px-10 py-4 rounded-[1.5rem] font-bold uppercase tracking-[0.2em] text-xs transition-all hover:scale-105 active:scale-95 shadow-2xl">
            <span class="material-symbols-outlined">download</span>
            Descargar Archivo
        </a>
    </div>
</div>

<script>
    if (typeof openImageModal !== 'function') {
        window.openImageModal = function (imageSrc) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            img.src = imageSrc;
            const downloadBtn = document.getElementById('downloadButton');
            if (downloadBtn) downloadBtn.href = imageSrc;

            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeImageModal = function () {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            if (img) {
                img.classList.remove('scale-100', 'opacity-100');
                img.classList.add('scale-95', 'opacity-0');
            }

            setTimeout(() => {
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = 'auto';
                }
            }, 300);
        };

        document.addEventListener('keydown', function (e) {
            const modal = document.getElementById('imageModal');
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeImageModal();
            }
        });
    }
</script>