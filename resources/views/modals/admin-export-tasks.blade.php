{{-- Modal para exportar PDF --}}
<div id="exportModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4"
    x-data="{ open: false }">
    <div
        class="bg-white dark:bg-[#242526] dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white flex items-center gap-3">
                <div class="p-2 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                Exportar Reporte PDF
            </h3>
            <button onclick="closeExportModal()"
                class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-300 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.tasks.export-pdf') }}" method="GET" class="space-y-5">
            <div>
                <label for="month"
                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-2">
                    Mes
                </label>
                <select id="month" name="month" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
                    <option value="">Seleccionar mes</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12" selected>Diciembre</option>
                </select>
            </div>

            <div>
                <label for="year"
                    class="block text-sm font-semibold text-gray-700 dark:text-gray-200 dark:text-gray-300 mb-2">
                    Año
                </label>
                <select id="year" name="year" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 dark:text-gray-200 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
                    <option value="">Seleccionar año</option>
                    @php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= 2020; $y--) {
                            echo "<option value=\"$y\"" . ($y == $currentYear ? ' selected' : '') . ">$y</option>";
                        }
                    @endphp
                </select>
            </div>

            <div
                class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-gray-700 dark:text-gray-200 dark:text-gray-300">
                        <p class="font-semibold mb-1">Información</p>
                        <p>Se exportarán únicamente las tareas <strong>finalizadas</strong> durante el mes y año
                            seleccionado.</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeExportModal()"
                    class="flex-1 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-200 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold transition">
                    Cancelar
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 rounded-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 font-semibold shadow-lg hover:shadow-xl transition">
                    Generar PDF
                </button>
            </div>
        </form>
    </div>
</div>