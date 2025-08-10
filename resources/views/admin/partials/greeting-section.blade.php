<!-- Enhanced Greeting Section - Dark Mode Friendly -->
<div class="relative bg-gradient-to-br {{ $greeting['color'] }} dark:from-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl dark:shadow-gray-900/50 overflow-hidden border dark:border-gray-700/50">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20 dark:opacity-10">
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-white dark:bg-gray-300 rounded-full animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-white dark:bg-gray-300 rounded-full animate-pulse animation-delay-1000"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white dark:bg-gray-300 rounded-full animate-pulse animation-delay-2000"></div>
    </div>
    
    <!-- Main Content -->
    <div class="relative z-10 p-6 sm:p-8">
        <!-- Header Row -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-6">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="bg-white/20 dark:bg-gray-700/60 backdrop-blur-sm rounded-2xl p-4 mr-4 shadow-lg dark:shadow-gray-900/30 border dark:border-gray-600/30">
                    <i class="fas {{ $greeting['icon_waktu'] }} text-3xl text-white dark:text-gray-200"></i>
                </div>
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white dark:text-gray-100 mb-1">
                        {{ $greeting['salam'] }}! 
                    </h3>
                    <p class="text-white/80 dark:text-gray-300 text-sm font-medium">{{ $greeting['tanggal'] }}</p>
                </div>
            </div>
            
            <!-- Status Icon -->
            <div class="bg-white/15 dark:bg-gray-700/40 backdrop-blur-sm rounded-2xl p-4 shadow-lg dark:shadow-gray-900/30 self-center sm:self-start border dark:border-gray-600/30">
                <i class="fas {{ $greeting['icon'] }} text-2xl text-white dark:text-gray-200"></i>
            </div>
        </div>
        
        <!-- Main Message -->
        <div class="bg-white/15 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 mb-6 border border-slate-950 dark:border-slate-600/30 shadow-lg dark:shadow-gray-900/20">
            <div class="flex items-start">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 bg-white/20 dark:bg-gray-700/50 rounded-xl flex items-center justify-center border dark:border-gray-600/20">
                        <i class="fas fa-lightbulb text-2xl text-yellow-300 dark:text-yellow-400 dark:drop-shadow-[0_0_10px_rgba(255,255,200,0.3)]"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-white dark:text-gray-100 font-bold text-lg mb-2">Financial Insight</h4>
                    <p class="text-white/95 dark:text-gray-200 text-base leading-relaxed font-medium">
                        {{ $greeting['pesan'] }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <!-- Pengeluaran Hari Ini -->
            <div class="bg-white/10 dark:bg-gray-800/40 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-600/20">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 dark:bg-gray-700/50 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-wallet text-white dark:text-gray-200"></i>
                    </div>
                    <div>
                        <p class="text-white/70 dark:text-gray-300 text-xs font-medium">Hari Ini</p>
                        <p class="text-white dark:text-gray-100 text-lg font-bold">
                            {{ \App\Helpers\DashboardGreetingHelper::formatRupiah($greeting['pengeluaran_hari_ini']) }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Rata-rata Harian -->
            <div class="bg-white/10 dark:bg-gray-800/40 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-600/20">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 dark:bg-gray-700/50 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-line text-white dark:text-gray-200"></i>
                    </div>
                    <div>
                        <p class="text-white/70 dark:text-gray-300 text-xs font-medium">Rata-rata</p>
                        <p class="text-white dark:text-gray-100 text-lg font-bold">
                            {{ \App\Helpers\DashboardGreetingHelper::formatRupiah($greeting['rata_rata']) }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Persentase -->
            <div class="bg-white/10 dark:bg-gray-800/40 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-600/20">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 dark:bg-gray-700/50 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-percentage text-white dark:text-gray-200"></i>
                    </div>
                    <div>
                        <p class="text-white/70 dark:text-gray-300 text-xs font-medium">vs Rata-rata</p>
                        <p class="text-white dark:text-gray-100 text-lg font-bold">{{ $greeting['persentase_vs_rata'] }}%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status Badge -->
        <div class="flex justify-center">
            <div class="inline-flex items-center {{ $greeting['badge_color'] }} dark:bg-gray-700/60 dark:text-gray-200 dark:border-gray-500/30 px-6 py-3 rounded-full text-sm font-bold border backdrop-blur-sm">
                <span class="mr-2 text-lg">
                    <i class="fas {{ $greeting['badge_icon'] }} {{ $greeting['icon_badge_color'] }} dark:text-gray-300"></i>
                </span>
                <span class="dark:text-gray-200">{{ $greeting['badge_text'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Custom Animation Delays -->
<style>
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    /* Dark mode smooth transitions */
    .dark * {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }
    
    /* Enhanced dark mode glow effects */
    .dark .fas.fa-lightbulb {
        filter: drop-shadow(0 0 8px rgba(255, 255, 200, 0.4));
    }
</style>