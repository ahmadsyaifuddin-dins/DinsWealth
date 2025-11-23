<!-- Enhanced Greeting Section - Dark Mode Friendly & Mobile Optimized -->
<div
    class="relative bg-gradient-to-br {{ $greeting['color'] }} dark:from-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl dark:shadow-gray-900/50 overflow-hidden border dark:border-gray-700/50 transition-all duration-300">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20 dark:opacity-10 pointer-events-none">
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-white dark:bg-gray-300 rounded-full animate-pulse"></div>
        <div
            class="absolute -bottom-4 -left-4 w-32 h-32 bg-white dark:bg-gray-300 rounded-full animate-pulse animation-delay-1000">
        </div>
        <div
            class="absolute top-1/2 left-1/3 w-16 h-16 bg-white dark:bg-gray-300 rounded-full animate-pulse animation-delay-2000">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 p-6 sm:p-8">
        <!-- Header Row -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-6">
            <div class="flex items-center mb-4 sm:mb-0">
                <div
                    class="bg-white/20 dark:bg-gray-700/60 backdrop-blur-sm rounded-2xl p-4 mr-4 shadow-lg dark:shadow-gray-900/30 border dark:border-gray-600/30 transition-colors duration-300">
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
            <div
                class="hidden sm:block bg-white/15 dark:bg-gray-700/40 backdrop-blur-sm rounded-2xl p-4 shadow-lg dark:shadow-gray-900/30 self-center sm:self-start border dark:border-gray-600/30 transition-colors duration-300">
                <i class="fas {{ $greeting['icon'] }} text-2xl text-white dark:text-gray-200"></i>
            </div>
        </div>

        <!-- Main Message (AI Integration) - Mobile Optimized Layout -->
        <div
            class="bg-white/15 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-5 sm:p-6 mb-6 border border-slate-950/10 dark:border-slate-600/30 shadow-lg dark:shadow-gray-900/20 relative overflow-hidden group transition-all duration-300">

            <!-- Glow Effect for AI -->
            @if (!empty($aiInsight) && !str_contains($aiInsight, 'Error'))
                <div
                    class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl group-hover:bg-blue-400/30 transition duration-1000">
                </div>
            @endif

            <!--
                LAYOUT FIX:
                Menggunakan 'flex-col' (atas-bawah) untuk Mobile,
                dan 'sm:flex-row' (samping) untuk Tablet/Desktop
            -->
            <div class="flex flex-col sm:flex-row items-start relative z-10">

                <!-- Icon Container -->
                <div class="flex items-center w-full sm:w-auto mb-3 sm:mb-0 sm:mr-4">
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 dark:bg-gray-700/50 rounded-xl flex items-center justify-center border dark:border-gray-600/20 transition-colors duration-300 flex-shrink-0">
                        @if (!empty($aiInsight) && !str_contains($aiInsight, 'Error'))
                            <i
                                class="fas fa-robot text-xl sm:text-2xl text-blue-100 dark:text-blue-400 animate-pulse"></i>
                        @else
                            <i
                                class="fas fa-lightbulb text-xl sm:text-2xl text-yellow-300 dark:text-yellow-400 dark:drop-shadow-[0_0_10px_rgba(255,255,200,0.3)]"></i>
                        @endif
                    </div>

                    <!-- Title pindah ke sebelah Icon KHUSUS MOBILE agar header rapi -->
                    <div class="ml-3 sm:hidden flex-1">
                        <div class="flex items-center gap-2">
                            <h4 class="text-white dark:text-gray-100 font-bold text-base">
                                @if (!empty($aiInsight) && !str_contains($aiInsight, 'Error'))
                                    AI Analysis
                                @else
                                    Financial Insight
                                @endif
                            </h4>
                            @if (!empty($aiInsight) && !str_contains($aiInsight, 'Error'))
                                <span
                                    class="text-[9px] uppercase tracking-wider text-blue-100 dark:text-blue-300 border border-blue-200/40 dark:border-blue-500/30 px-1.5 py-0.5 rounded-full bg-blue-500/10">
                                    AI
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Text Container -->
                <div class="flex-1 w-full" x-data="{ expanded: false }">
                    <!-- Header Title Desktop Only -->
                    <div class="hidden sm:flex justify-between items-center mb-2 flex-wrap gap-2">
                        <h4 class="text-white dark:text-gray-100 font-bold text-lg">
                            @if (!empty($aiInsight) && !str_contains($aiInsight, 'Error'))
                                AI Financial Analysis
                            @else
                                Financial Insight
                            @endif
                        </h4>

                        @if (!empty($aiInsight) && !str_contains($aiInsight, 'Error'))
                            <span
                                class="text-[10px] uppercase tracking-wider text-blue-100 dark:text-blue-300 border border-blue-200/40 dark:border-blue-500/30 px-2 py-0.5 rounded-full bg-blue-500/10 backdrop-blur-sm">
                                AI Generated
                            </span>
                        @endif
                    </div>

                    <!--
                        TEXT CONTENT FIX:
                        1. id="insight-text" untuk targeting JS (opsional jika pakai Alpine)
                        2. class 'line-clamp-3' memotong teks jadi 3 baris di awal
                    -->
                    <div class="relative">
                        <div id="insight-text"
                            class="text-white/95 dark:text-gray-200 text-sm sm:text-base leading-relaxed font-medium transition-colors duration-300 line-clamp-3">
                            @if (!empty($aiInsight))
                                {!! nl2br(e($aiInsight)) !!}
                            @else
                                {{ $greeting['pesan'] }}
                            @endif
                        </div>

                        <!-- Tombol Baca Selengkapnya (Hanya muncul jika teks panjang) -->
                        <button id="toggle-insight-btn" onclick="toggleInsight()"
                            class="mt-2 text-xs font-bold text-yellow-200 dark:text-yellow-400 hover:text-white dark:hover:text-white flex items-center gap-1 focus:outline-none bg-black/20 px-3 py-1 rounded-full sm:hidden">
                            <span>Baca Selengkapnya</span>
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <!-- Pengeluaran Hari Ini -->
            <div
                class="bg-white/10 dark:bg-gray-800/40 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-600/20 hover:bg-white/20 dark:hover:bg-gray-700/50 transition duration-300">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-white/20 dark:bg-gray-700/50 rounded-lg flex items-center justify-center mr-3 transition-colors duration-300">
                        <i class="fas fa-wallet text-white dark:text-gray-200"></i>
                    </div>
                    <div>
                        <p class="text-white/70 dark:text-gray-400 text-xs font-medium">Hari Ini</p>
                        <p class="text-white dark:text-gray-100 text-lg font-bold">
                            {{ \App\Helpers\DashboardGreetingHelper::formatRupiah($greeting['pengeluaran_hari_ini']) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Harian -->
            <div
                class="bg-white/10 dark:bg-gray-800/40 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-600/20 hover:bg-white/20 dark:hover:bg-gray-700/50 transition duration-300">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-white/20 dark:bg-gray-700/50 rounded-lg flex items-center justify-center mr-3 transition-colors duration-300">
                        <i class="fas fa-chart-line text-white dark:text-gray-200"></i>
                    </div>
                    <div>
                        <p class="text-white/70 dark:text-gray-400 text-xs font-medium">Rata-rata</p>
                        <p class="text-white dark:text-gray-100 text-lg font-bold">
                            {{ \App\Helpers\DashboardGreetingHelper::formatRupiah($greeting['rata_rata']) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Persentase -->
            <div
                class="bg-white/10 dark:bg-gray-800/40 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-600/20 hover:bg-white/20 dark:hover:bg-gray-700/50 transition duration-300">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-white/20 dark:bg-gray-700/50 rounded-lg flex items-center justify-center mr-3 transition-colors duration-300">
                        <i class="fas fa-percentage text-white dark:text-gray-200"></i>
                    </div>
                    <div>
                        <p class="text-white/70 dark:text-gray-400 text-xs font-medium">vs Rata-rata</p>
                        <p class="text-white dark:text-gray-100 text-lg font-bold">
                            {{ $greeting['persentase_vs_rata'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="flex justify-center">
            <div
                class="inline-flex items-center {{ $greeting['badge_color'] }} dark:bg-gray-700/60 dark:text-gray-200 dark:border-gray-500/30 px-6 py-3 rounded-full text-sm font-bold border backdrop-blur-sm shadow-sm transition-all duration-300 hover:scale-105">
                <span class="mr-2 text-lg">
                    <i
                        class="fas {{ $greeting['badge_icon'] }} {{ $greeting['icon_badge_color'] }} dark:text-gray-300"></i>
                </span>
                <span class="dark:text-gray-200">{{ $greeting['badge_text'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Custom Animation Delays & Javascript Toggle -->
<style>
    .animation-delay-1000 {
        animation-delay: 1s;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .dark * {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }

    .dark .fas.fa-lightbulb {
        filter: drop-shadow(0 0 8px rgba(255, 255, 200, 0.4));
    }

    /* Line Clamp utility if not in Tailwind config */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    function toggleInsight() {
        const textDiv = document.getElementById('insight-text');
        const btn = document.getElementById('toggle-insight-btn');
        const icon = btn.querySelector('i');
        const span = btn.querySelector('span');

        if (textDiv.classList.contains('line-clamp-3')) {
            // Expand
            textDiv.classList.remove('line-clamp-3');
            span.innerText = 'Tutup';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            // Collapse
            textDiv.classList.add('line-clamp-3');
            span.innerText = 'Baca Selengkapnya';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>
