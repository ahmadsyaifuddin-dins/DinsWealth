<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <!-- Today's Spending -->
    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
        <div class="text-center">
            <div class="flex items-center justify-center mb-2">
                <i class="fas fa-calendar-day text-white/70 mr-2"></i>
                <p class="text-white/70 text-xs font-semibold uppercase tracking-wider">Hari Ini</p>
            </div>
            <p class="text-white text-xl font-bold">
                {{ App\Helpers\DashboardGreetingHelper::formatRupiah($greeting['pengeluaran_hari_ini']) }}
            </p>
        </div>
    </div>
    
    <!-- Average Daily -->
    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
        <div class="text-center">
            <div class="flex items-center justify-center mb-2">
                <i class="fas fa-chart-line text-white/70 mr-2"></i>
                <p class="text-white/70 text-xs font-semibold uppercase tracking-wider">Rata-rata</p>
            </div>
            <p class="text-white text-xl font-bold">
                {{ App\Helpers\DashboardGreetingHelper::formatRupiah($greeting['rata_rata']) }}
            </p>
        </div>
    </div>
    
    <!-- Comparison -->
    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
        <div class="text-center">
            <div class="flex items-center justify-center mb-2">
                <i class="fas fa-balance-scale text-white/70 mr-2"></i>
                <p class="text-white/70 text-xs font-semibold uppercase tracking-wider">Perbandingan</p>
            </div>
            <p class="text-white text-sm font-bold">
                {{ App\Helpers\DashboardGreetingHelper::getSpendingComparison($greeting['pengeluaran_hari_ini'], $greeting['rata_rata']) }}
            </p>
        </div>
    </div>
</div>