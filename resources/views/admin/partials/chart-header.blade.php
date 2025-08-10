<div class="flex flex-col xl:flex-row xl:items-center xl:justify-between mb-8 gap-6">
    <div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">📊 Analisis Pengeluaran</h3>
        <p class="text-gray-600" id="chartDescription">Visualisasi trend pengeluaran 7 hari terakhir</p>
    </div>
    
    <!-- Enhanced Controls -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
        
        <!-- Period Toggle -->
        <div class="bg-gray-100 rounded-2xl p-1.5 shadow-inner">
            <div class="flex">
                <button id="periodWeekly" class="px-4 py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-red-500 to-pink-600 text-white shadow-lg transition-all duration-300">
                    <i class="fas fa-calendar-week mr-2"></i>7 Hari
                </button>
                <button id="periodMonthly" class="px-4 py-2.5 text-sm font-bold rounded-xl text-gray-600 hover:text-gray-800 hover:bg-white transition-all duration-300">
                    <i class="fas fa-calendar-alt mr-2"></i>1 Bulan
                </button>
            </div>
        </div>
        
        <!-- Chart Type Toggle -->
        <div class="bg-gray-100 rounded-2xl p-1.5 shadow-inner">
            <div class="flex">
                <button id="chartLine" class="p-3 rounded-xl text-gray-600 hover:text-gray-800 hover:bg-white transition-all duration-300" title="Line Chart">
                    <i class="fas fa-chart-line"></i>
                </button>
                <button id="chartBar" class="p-3 rounded-xl bg-gradient-to-r from-red-500 to-pink-600 text-white shadow-lg transition-all duration-300" title="Bar Chart">
                    <i class="fas fa-chart-bar"></i>
                </button>
            </div>
        </div>
    </div>
</div>