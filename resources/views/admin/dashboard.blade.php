<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-gray-900">
                    Halo, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $greeting['salam'] }}, semoga harimu menyenangkan!
                </p>
            </div>
            <div class="mt-3 sm:mt-0 text-right">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Dashboard Keuangan</p>
                <p class="text-sm text-gray-700 font-medium">{{ $greeting['tanggal'] }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:space-y-8">
            
            <!-- Enhanced Greeting Section -->
            <div class="relative bg-gradient-to-br {{ $greeting['color'] }} rounded-3xl shadow-2xl overflow-hidden">
                <!-- Animated Background Elements -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-white rounded-full animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-white rounded-full animate-pulse animation-delay-1000"></div>
                    <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white rounded-full animate-pulse animation-delay-2000"></div>
                </div>
                
                <!-- Main Content -->
                <div class="relative z-10 p-6 sm:p-8">
                    <!-- Header Row -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-6">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 mr-4 shadow-lg">
                                <i class="fas {{ $greeting['icon_waktu'] }} text-3xl text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-white mb-1">
                                    {{ $greeting['salam'] }}! 
                                </h3>
                                <p class="text-white/80 text-sm font-medium">{{ $greeting['tanggal'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Status Icon -->
                        <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 shadow-lg self-center sm:self-start">
                            <i class="fas {{ $greeting['icon'] }} text-2xl text-white"></i>
                        </div>
                    </div>
                    
                    <!-- Main Message -->
                    <div class="bg-white/15 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white/20 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <span class="text-2xl">💡</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-bold text-lg mb-2">Financial Insight</h4>
                                <p class="text-white/95 text-base leading-relaxed font-medium">
                                    {{ $greeting['pesan'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Grid -->
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
                    
                    <!-- Status Badge -->
                    <div class="flex justify-center">
                        <div class="inline-flex items-center {{ $greeting['badge_color'] }} px-6 py-3 rounded-full text-sm font-bold border backdrop-blur-sm">
                            <span class="mr-2 text-lg">{{ $greeting['badge_icon'] }}</span>
                            {{ $greeting['badge_text'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Saldo Card -->
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
                                <i class="fa-solid fa-scale-balanced mr-2"></i>
                                <span>Current Balance</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Income Card -->
                <div class="group relative bg-gradient-to-br from-emerald-500 via-green-600 to-teal-700 rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                                <i class="fas fa-arrow-trend-up text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="w-2 h-2 bg-white/40 rounded-full"></div>
                            </div>
                        </div>
                        <div>
                            <p class="text-emerald-100 text-xs uppercase tracking-widest font-semibold mb-2">Pemasukan</p>
                            <p class="text-white text-2xl lg:text-3xl font-bold mb-3">
                                {{ App\Helpers\DashboardGreetingHelper::formatRupiah($pemasukanBulanIni) }}
                            </p>
                            <div class="flex items-center text-emerald-100 text-xs">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expense Card -->
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
                
                <!-- Quick Actions Card -->
                <div class="group relative bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="text-center mb-4">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg">Quick Actions</h3>
                        <p class="text-gray-500 text-xs mt-1">Aksi Cepat</p>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('tabungan.index') }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-wallet mr-2"></i>Kelola Tabungan
                        </a>
                        
                        <button onclick="openModal()" class="w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Backup Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Left Side - Info -->
                    <div class="mb-6 lg:mb-0 lg:flex-1">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-blue-500 to-cyan-600 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Data Backup & Export</h3>
                                <p class="text-gray-600">Lindungi data keuanganmu dengan backup berkala</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-xl p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-file-code text-blue-600 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">JSON Format</p>
                                        <p class="text-gray-600 text-xs">Data lengkap dengan struktur</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-table text-green-600 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">CSV Format</p>
                                        <p class="text-gray-600 text-xs">Compatible dengan Excel</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Form -->
                    <div class="lg:flex-shrink-0 lg:ml-8">
                        <form method="POST" action="{{ route('backup.download') }}" class="w-full lg:w-80">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="format" class="block text-sm font-bold text-gray-700 mb-3">
                                        <i class="fas fa-file-export mr-2 text-blue-600"></i>
                                        Pilih Format Export:
                                    </label>
                                    <select name="format" id="format" class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 font-medium text-gray-700" required>
                                        <option value="" class="text-gray-400">-- Pilih Format --</option>
                                        <option value="json">📄 JSON (Data Lengkap)</option>
                                        <option value="csv">📊 CSV (Excel Compatible)</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold py-4 px-6 rounded-2xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-cloud-download-alt mr-3 text-lg"></i>
                                    Download Backup
                                </button>
                            </div>
                            
                            <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border border-blue-100">
                                <div class="flex items-start text-blue-800 text-sm">
                                    <i class="fas fa-info-circle mr-3 mt-0.5 text-blue-600"></i>
                                    <div>
                                        <p class="font-semibold mb-1">Tips Backup:</p>
                                        <p class="text-xs text-blue-700">Lakukan backup secara berkala untuk menjaga keamanan data keuanganmu</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Chart and Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Enhanced Chart Section -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    
                    <!-- Chart Header with Enhanced Controls -->
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
                    
                    <!-- Chart Container with Enhanced Design -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-inner">
                        <canvas id="expenseChart" height="300" class="rounded-xl"></canvas>
                        
                        <!-- Chart Overlay Info -->
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg">
                            <p class="text-xs text-gray-600 font-medium" id="chartInfo">Loading...</p>
                        </div>
                    </div>
                    
                    <!-- Enhanced Chart Stats -->
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-100">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line text-blue-600 mr-3 text-lg"></i>
                                <div>
                                    <p class="text-blue-800 font-bold text-sm">Trend Analysis</p>
                                    <p class="text-blue-600 text-xs">Pola pengeluaran</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                            <div class="flex items-center">
                                <i class="fas fa-calculator text-green-600 mr-3 text-lg"></i>
                                <div>
                                    <p class="text-green-800 font-bold text-sm">Smart Insights</p>
                                    <p class="text-green-600 text-xs">Analisis otomatis</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100">
                            <div class="flex items-center">
                                <i class="fas fa-bullseye text-purple-600 mr-3 text-lg"></i>
                                <div>
                                    <p class="text-purple-800 font-bold text-sm">Goal Tracking</p>
                                    <p class="text-purple-600 text-xs">Monitor target</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Recent Activity -->
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    
                    <!-- Activity Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-1">🕒 Aktivitas Terbaru</h3>
                            <p class="text-gray-600 text-sm">Transaksi terkini</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-history text-white text-lg"></i>
                        </div>
                    </div>
                    
                    <!-- Activity List -->
                    <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
                        @forelse ($transaksiTerakhir as $index => $item)
                            <div class="group relative flex items-center justify-between p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl hover:from-gray-100 hover:to-gray-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                
                                <!-- Transaction Icon and Info -->
                                <div class="flex items-center flex-1">
                                    <div class="relative w-12 h-12 rounded-2xl flex items-center justify-center mr-4 shadow-lg {{ $item->kategoriJenis->jenis === 'Pemasukan' ? 'bg-gradient-to-br from-green-500 to-emerald-600' : 'bg-gradient-to-br from-red-500 to-pink-600' }}">
                                        @if($item->kategoriJenis->jenis === 'Pemasukan')
                                            <i class="fa-solid fa-arrow-up text-white text-lg"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down text-white text-lg"></i>
                                        @endif
                                        
                                        <!-- Badge for transaction order -->
                                        <div class="absolute -top-2 -right-2 bg-white text-gray-600 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-lg">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900 text-sm mb-1">
                                            {{ $item->kategoriNama?->nama ?? 'Kategori Dihapus' }}
                                        </p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <span>{{ $item->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Amount -->
                                <div class="text-right ml-4">
                                    <p class="font-bold text-lg {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->kategoriJenis->jenis === 'Pemasukan' ? '+' : '-' }}{{ App\Helpers\DashboardGreetingHelper::formatRupiah($item->nominal) }}
                                    </p>
                                    <div class="flex items-center justify-end mt-1">
                                        <div class="w-2 h-2 rounded-full {{ $item->kategoriJenis->jenis === 'Pemasukan' ? 'bg-green-400' : 'bg-red-400' }}"></div>
                                        <span class="ml-2 text-xs text-gray-400 font-medium">
                                            {{ $item->kategoriJenis->jenis }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="text-center py-12">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <i class="fas fa-receipt text-gray-400 text-2xl"></i>
                                </div>
                                <h4 class="text-gray-700 font-bold text-lg mb-2">Belum Ada Transaksi</h4>
                                <p class="text-gray-500 text-sm mb-6">Mulai tambahkan transaksi pertamamu</p>
                                <button onclick="openModal()" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-2xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                                </button>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- View All Button -->
                    @if($transaksiTerakhir->count() > 0)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <a href="{{ route('tabungan.index') }}" class="block text-center bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-2xl transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-list mr-2"></i>Lihat Semua Transaksi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Include Modal Tambah Transaksi --}}
    @include('tabungan.partials.modal-tabungan')
    
    @push('scripts')
        {{-- Include script modal jika belum ada --}}
        @include('tabungan.partials._scripts') 
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data dari controller
                const monthlyData = @json($monthlyChartData ?? null);
                const weeklyData = @json($weeklyChartData ?? null);
                
                // Chart instance
                let chart = null;
                
                // Current settings
                let currentPeriod = 'weekly'; // weekly | monthly
                let currentType = 'bar';      // bar | line
                
                // DOM Elements
                const canvas = document.getElementById('expenseChart');
                const periodWeekly = document.getElementById('periodWeekly');
                const periodMonthly = document.getElementById('periodMonthly');
                const chartLine = document.getElementById('chartLine');
                const chartBar = document.getElementById('chartBar');
                const chartDescription = document.getElementById('chartDescription');
                const chartInfo = document.getElementById('chartInfo');
                
                // Initialize chart with enhanced styling
                function initChart() {
                    if (chart) {
                        chart.destroy();
                    }
                    
                    const data = currentPeriod === 'weekly' ? weeklyData : monthlyData;
                    if (!data || !data.labels.length) {
                        chartInfo.textContent = 'Tidak ada data tersedia';
                        return;
                    }
                    
                    const ctx = canvas.getContext('2d');
                    
                    chart = new Chart(ctx, {
                        type: currentType,
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Pengeluaran Harian',
                                data: data.data,
                                backgroundColor: currentType === 'line' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(239, 68, 68, 0.8)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: currentType === 'line' ? 3 : 2,
                                fill: currentType === 'line',
                                tension: currentType === 'line' ? 0.4 : 0,
                                pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 3,
                                pointRadius: currentType === 'line' ? 6 : 0,
                                pointHoverRadius: currentType === 'line' ? 8 : 0,
                                borderRadius: currentType === 'bar' ? 12 : 0,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(239, 68, 68, 1)',
                                    borderWidth: 2,
                                    cornerRadius: 12,
                                    displayColors: false,
                                    titleFont: { size: 14, weight: 'bold' },
                                    bodyFont: { size: 13 },
                                    padding: 12,
                                    callbacks: {
                                        title: function(context) {
                                            return `Tanggal ${context[0].label}`;
                                        },
                                        label: function(context) {
                                            return `💰 Pengeluaran: Rp${context.parsed.y.toLocaleString('id-ID')}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.08)',
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            if (value >= 1000000) {
                                                return 'Rp' + (value/1000000).toFixed(1) + 'M';
                                            } else if (value >= 1000) {
                                                return 'Rp' + (value/1000).toFixed(0) + 'K';
                                            }
                                            return 'Rp' + value.toLocaleString('id-ID');
                                        },
                                        font: { weight: 'bold' }
                                    }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        maxTicksLimit: currentPeriod === 'monthly' ? 15 : 7,
                                        font: { weight: 'bold' }
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });
                    
                    updateUI();
                }
                
                // Update UI descriptions
                function updateUI() {
                    const data = currentPeriod === 'weekly' ? weeklyData : monthlyData;
                    
                    if (currentPeriod === 'weekly') {
                        chartDescription.textContent = '📈 Visualisasi trend pengeluaran 7 hari terakhir';
                        chartInfo.textContent = `Total: ${data.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace('IDR', 'Rp')}`;
                    } else {
                        chartDescription.textContent = `📊 Trend pengeluaran ${data.bulan}`;
                        chartInfo.textContent = `Total: ${data.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).replace('IDR', 'Rp')}`;
                    }
                }
                
                // Enhanced toggle active states
                function setActiveButton(activeBtn, inactiveBtn) {
                    // Reset inactive button
                    inactiveBtn.classList.remove('bg-gradient-to-r', 'from-red-500', 'to-pink-600', 'text-white', 'shadow-lg');
                    inactiveBtn.classList.add('text-gray-600', 'hover:text-gray-800', 'hover:bg-white');
                    
                    // Set active button
                    activeBtn.classList.remove('text-gray-600', 'hover:text-gray-800', 'hover:bg-white');
                    activeBtn.classList.add('bg-gradient-to-r', 'from-red-500', 'to-pink-600', 'text-white', 'shadow-lg');
                }
                
                // Event listeners with enhanced feedback
                periodWeekly.addEventListener('click', () => {
                    if (currentPeriod !== 'weekly') {
                        currentPeriod = 'weekly';
                        setActiveButton(periodWeekly, periodMonthly);
                        initChart();
                    }
                });
                
                periodMonthly.addEventListener('click', () => {
                    if (currentPeriod !== 'monthly') {
                        currentPeriod = 'monthly';
                        setActiveButton(periodMonthly, periodWeekly);
                        initChart();
                    }
                });
                
                chartLine.addEventListener('click', () => {
                    if (currentType !== 'line') {
                        currentType = 'line';
                        setActiveButton(chartLine, chartBar);
                        initChart();
                    }
                });
                
                chartBar.addEventListener('click', () => {
                    if (currentType !== 'bar') {
                        currentType = 'bar';
                        setActiveButton(chartBar, chartLine);
                        initChart();
                    }
                });
                
                // Initialize with loading state
                chartInfo.textContent = 'Memuat data...';
                
                // Initialize chart after a short delay for better UX
                setTimeout(() => {
                    if (canvas && (weeklyData || monthlyData)) {
                        initChart();
                    } else {
                        chartInfo.textContent = 'Tidak ada data untuk ditampilkan';
                    }
                }, 500);
            });
        </script>
        
        <style>
            /* Custom scrollbar for activity list */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 10px;
            }
            
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #ef4444, #ec4899);
                border-radius: 10px;
            }
            
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #dc2626, #db2777);
            }
            
            /* Animation delays for background elements */
            .animation-delay-1000 {
                animation-delay: 1s;
            }
            
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            
            /* Enhanced hover effects */
            .group:hover .group-hover\:scale-110 {
                transform: scale(1.1);
            }
        </style>
    @endpush
</x-app-layout>