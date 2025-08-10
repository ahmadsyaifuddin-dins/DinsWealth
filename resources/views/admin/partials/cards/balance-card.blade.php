<div class="group relative bg-gradient-to-br from-blue-500 via-blue-600 to-purple-700 rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-purple-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <i class="fas fa-wallet text-white text-xl"></i>
            </div>
            <div class="text-right">
                <div class="w-2 h-2 bg-white/40 rounded-full"></div>
            </div>
        </div>
        <div>
            <p class="text-blue-100 text-xs uppercase tracking-widest font-semibold mb-2">Total Saldo</p>
            <p class="text-white text-2xl lg:text-3xl font-bold mb-3">
                {{ App\Helpers\DashboardGreetingHelper::formatRupiah($saldoSaatIni) }}
            </p>
            <div class="flex items-center text-blue-100 text-xs">
                <i class="fa-solid fa-coins mr-2"></i>
                <span>Current Balance</span>
            </div>
        </div>
    </div>
</div>