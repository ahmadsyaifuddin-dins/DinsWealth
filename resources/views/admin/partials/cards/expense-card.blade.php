<div class="group relative bg-gradient-to-br from-red-500 via-pink-600 to-rose-700 rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
    <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-rose-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <i class="fas fa-arrow-trend-down text-white text-xl"></i>
            </div>
            <div class="text-right">
                <div class="w-2 h-2 bg-white/40 rounded-full"></div>
            </div>
        </div>
        <div>
            <p class="text-red-100 text-xs uppercase tracking-widest font-semibold mb-2">Pengeluaran</p>
            <p class="text-white text-2xl lg:text-3xl font-bold mb-3">
                {{ App\Helpers\DashboardGreetingHelper::formatRupiah($pengeluaranBulanIni) }}
            </p>
            <div class="flex items-center text-red-100 text-xs">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM Y') }}</span>
            </div>
        </div>
    </div>
</div>