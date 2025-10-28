<div class="mb-8">
    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        <i class="fa-solid fa-chart-pie mr-2"></i>
        Ringkasan Visual
    </h3>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4 sm:p-6">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2 text-center">
                <i class="fa-solid fa-chart-pie mr-2"></i>
                Pemasukan vs Pengeluaran
            </h4>
            <canvas id="pieChart"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4 sm:p-6">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2 text-center">
                <i class="fa-solid fa-chart-bar mr-2"></i>
                Top 5 Kategori Pengeluaran
            </h4>
            <canvas id="barChart"></canvas>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4 sm:p-6 lg:col-span-2">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 space-y-3 sm:space-y-0">
                <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 text-center sm:text-left">
                    <i class="fa-solid fa-chart-line mr-2"></i>
                    Riwayat Arus Kas
                </h4>
                <div class="flex justify-center sm:justify-end">
                    <div
                        class="inline-flex bg-gray-100 dark:bg-gray-700 p-1 rounded-lg w-full sm:w-auto border dark:border-gray-600">

                        {{-- Tombol Harian (Default Aktif) --}}
                        <button id="lineChartDailyBtn"
                            class="flex-1 sm:flex-none px-3 py-2 text-xs sm:text-sm font-medium rounded-md bg-indigo-600 text-white shadow-md dark:bg-indigo-500 dark:text-white transform scale-105 transition-all duration-200">
                            Harian
                        </button>

                        {{-- Tombol Mingguan (BARU) --}}
                        <button id="lineChartWeeklyBtn"
                            class="flex-1 sm:flex-none px-3 py-2 text-xs sm:text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                            <span class="sm:hidden">Mggu</span>
                            <span class="hidden sm:inline">Mingguan</span>
                        </button>

                        {{-- Tombol Bulanan --}}
                        <button id="lineChartMonthlyBtn"
                            class="flex-1 sm:flex-none px-3 py-2 text-xs sm:text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                            <span class="sm:hidden">Bln</span>
                            <span class="hidden sm:inline">Bulanan</span>
                        </button>

                        {{-- Tombol Tahunan (BARU) --}}
                        <button id="lineChartYearlyBtn"
                            class="flex-1 sm:flex-none px-3 py-2 text-xs sm:text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                            <span class="sm:hidden">Thn</span>
                            <span class="hidden sm:inline">Tahunan</span>
                        </button>

                    </div>
                </div>
            </div>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>