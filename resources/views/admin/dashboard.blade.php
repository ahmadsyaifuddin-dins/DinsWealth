<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Halo, {{ Auth::user()->name }}!
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Selamat datang kembali. Ini ringkasan keuanganmu.
        </p>
    </x-slot>

    <div class="py-6 px-4 sm:py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <!-- Cards Grid - Responsive -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                
                <!-- Kartu Saldo Saat Ini -->
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2">
                            <i class="fas fa-wallet text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-blue-100 text-xs uppercase tracking-wide font-medium">Saldo Saat Ini</p>
                        <p class="text-2xl sm:text-3xl font-bold mt-1 mb-2">Rp{{ number_format($saldoSaatIni, 0, ',', '.') }}</p>
                        <div class="flex items-center text-blue-100 text-xs">
                            <i class="fas fa-chart-line mr-1"></i>
                            <span>Total Balance</span>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu Pemasukan Bulan Ini -->
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 text-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2">
                            <i class="fas fa-arrow-trend-up text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-emerald-100 text-xs uppercase tracking-wide font-medium">Pemasukan Bulan Ini</p>
                        <p class="text-2xl sm:text-3xl font-bold mt-1 mb-2">Rp{{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                        <div class="flex items-center text-emerald-100 text-xs">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kartu Pengeluaran Bulan Ini -->
                <div class="bg-gradient-to-br from-red-500 to-pink-600 text-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 rounded-xl p-2">
                            <i class="fas fa-arrow-trend-down text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-red-100 text-xs uppercase tracking-wide font-medium">Pengeluaran Bulan Ini</p>
                        <p class="text-2xl sm:text-3xl font-bold mt-1 mb-2">Rp{{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</p>
                        <div class="flex items-center text-red-100 text-xs">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Aksi Cepat -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="text-center mb-4">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-500 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800">Quick Actions</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('tabungan.index') }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-colors duration-300">
                            <i class="fas fa-wallet mr-2"></i>Kelola Tabungan
                        </a>
                        
                        <button onclick="openModal()" class="w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-colors duration-300">
                            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section Backup Data -->
            <div class="mb-6 sm:mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 w-10 h-10 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800">Data Backup</h3>
                            <p class="text-gray-600 text-sm">Download backup data keuangan</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('backup.download') }}" class="max-w-sm">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="format" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-file-export mr-2 text-blue-600"></i>
                                    Format Export:
                                </label>
                                <select name="format" id="format" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors duration-300 font-medium" required>
                                    <option value="">-- Pilih Format --</option>
                                    <option value="json">📄 JSON (Data Lengkap)</option>
                                    <option value="csv">📊 CSV (Excel)</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-cloud-download-alt mr-2"></i>
                                Download Backup
                            </button>
                        </div>
                        
                        <div class="mt-4 p-3 bg-blue-50 rounded-xl flex items-start text-blue-800 text-sm">
                            <i class="fas fa-info-circle mr-2 mt-0.5 text-blue-600"></i>
                            <span>Data akan diunduh dalam format yang dipilih</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Chart dan Activity Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Grafik dengan Controls -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <!-- Header dengan Controls -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800">Analisis Pengeluaran</h3>
                            <p class="text-gray-600 text-sm" id="chartDescription">Trend pengeluaran 7 hari terakhir</p>
                        </div>
                        
                        <!-- Chart Controls -->
                        <div class="flex items-center gap-2">
                            <!-- Period Toggle -->
                            <div class="flex bg-gray-100 rounded-xl p-1">
                                <button id="periodWeekly" class="px-3 py-2 text-xs font-semibold rounded-lg bg-red-500 text-white transition-all duration-300">
                                    7 Hari
                                </button>
                                <button id="periodMonthly" class="px-3 py-2 text-xs font-semibold rounded-lg text-gray-600 hover:text-gray-800 transition-all duration-300">
                                    1 Bulan
                                </button>
                            </div>
                            
                            <!-- Chart Type Toggle -->
                            <div class="flex bg-gray-100 rounded-xl p-1 ml-2">
                                <button id="chartLine" class="p-2 rounded-lg text-gray-600 hover:text-gray-800 transition-all duration-300" title="Line Chart">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                                <button id="chartBar" class="p-2 rounded-lg bg-red-500 text-white transition-all duration-300" title="Bar Chart">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chart Container -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <canvas id="expenseChart" height="300"></canvas>
                    </div>
                    
                    <!-- Chart Info -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
                        <span id="chartInfo">Total 7 hari: Rp0</span>
                        <span class="text-xs">Klik tombol untuk mengubah tampilan</span>
                    </div>
                </div>

                <!-- Aktivitas Terakhir -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
                            <p class="text-gray-600 text-sm">Transaksi terakhir</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-emerald-500 w-8 h-8 rounded-lg flex items-center justify-center">
                            <i class="fas fa-history text-white text-sm"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-3 max-h-80 overflow-y-auto">
                        @forelse ($transaksiTerakhir as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-300">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 {{ $item->kategoriJenis->jenis === 'Pemasukan' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        @if($item->kategoriJenis->jenis === 'Pemasukan')
                                            <i class="fa-solid fa-arrow-up"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $item->kategoriNama?->nama ?? 'Kategori Dihapus' }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->kategoriJenis->jenis === 'Pemasukan' ? '+' : '-' }}Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="bg-gray-100 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-receipt text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Belum ada transaksi</p>
                                <p class="text-gray-400 text-xs">Mulai tambah transaksi pertama</p>
                            </div>
                        @endforelse
                    </div>
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
                
                // Initialize chart
                function initChart() {
                    if (chart) {
                        chart.destroy();
                    }
                    
                    const data = currentPeriod === 'weekly' ? weeklyData : monthlyData;
                    if (!data || !data.labels.length) return;
                    
                    const ctx = canvas.getContext('2d');
                    
                    chart = new Chart(ctx, {
                        type: currentType,
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: currentPeriod === 'weekly' ? 'Pengeluaran Harian' : 'Pengeluaran Harian',
                                data: data.data,
                                backgroundColor: currentType === 'line' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(239, 68, 68, 0.8)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: currentType === 'line' ? 3 : 1,
                                fill: currentType === 'line',
                                tension: currentType === 'line' ? 0.4 : 0,
                                pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: currentType === 'line' ? 4 : 0,
                                pointHoverRadius: currentType === 'line' ? 6 : 0,
                                borderRadius: currentType === 'bar' ? 8 : 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(239, 68, 68, 1)',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return 'Pengeluaran: Rp' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.1)',
                                        drawBorder: false,
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value > 999 ? 'Rp' + (value/1000).toFixed(0) + 'k' : 'Rp' + value.toLocaleString('id-ID');
                                        }
                                    }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        maxTicksLimit: currentPeriod === 'monthly' ? 15 : 7,
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                        }
                    });
                    
                    updateUI();
                }
                
                // Update UI descriptions
                function updateUI() {
                    const data = currentPeriod === 'weekly' ? weeklyData : monthlyData;
                    
                    if (currentPeriod === 'weekly') {
                        chartDescription.textContent = 'Trend pengeluaran 7 hari terakhir';
                        chartInfo.textContent = `Total 7 hari: Rp${data.total.toLocaleString('id-ID')}`;
                    } else {
                        chartDescription.textContent = `Trend pengeluaran ${data.bulan}`;
                        chartInfo.textContent = `Total bulan: Rp${data.total.toLocaleString('id-ID')}`;
                    }
                }
                
                // Toggle active states
                function setActiveButton(activeBtn, inactiveBtn) {
                    activeBtn.classList.remove('text-gray-600', 'hover:text-gray-800');
                    activeBtn.classList.add('bg-red-500', 'text-white');
                    
                    inactiveBtn.classList.remove('bg-red-500', 'text-white');
                    inactiveBtn.classList.add('text-gray-600', 'hover:text-gray-800');
                }
                
                // Event listeners
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
                
                // Initialize
                if (canvas && (weeklyData || monthlyData)) {
                    initChart();
                }
            });
        </script>
    @endpush
</x-app-layout>