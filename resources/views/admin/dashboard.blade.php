<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Halo, {{ Auth::user()->name }}!
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Selamat datang kembali. Ini ringkasan keuanganmu.
        </p>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                {{-- 1. Kartu Ringkasan Utama --}}
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl shadow-lg p-6 h-32 flex flex-col justify-between">
                    <p class="text-indigo-100 text-sm">Saldo Saat Ini</p>
                    <p class="text-3xl font-bold">Rp{{ number_format($saldoSaatIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 h-32 flex flex-col justify-between">
                    <p class="text-gray-500 text-sm">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600">Rp{{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                </div>
                
                {{-- 2. Tombol Aksi Cepat --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-center space-y-3 h-auto min-h-[200px]">
                    <a href="{{ route('tabungan.index') }}" class="w-full text-center bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                        <i class="fas fa-wallet mr-2"></i>Kelola Tabungan
                    </a>
                    <button onclick="openModal()" class="w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                        <i class="fas fa-plus mr-2"></i>Tambah Transaksi Cepat
                    </button>
                    
                    {{-- Backup Section yang Dipercantik --}}
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-3 border border-slate-200">
                        <div class="flex items-center mb-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-download text-white text-xs"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-sm">Backup Data</h4>
                        </div>
                        
                        <form method="POST" action="{{ route('backup.download') }}" class="space-y-2">
                            @csrf
                            <div class="relative">
                                <label for="format" class="block text-xs font-medium text-gray-700 mb-1">
                                    <i class="fas fa-file-export mr-1 text-gray-500"></i>
                                    Format Export:
                                </label>
                                <select name="format" id="format" class="w-full px-3 py-2 bg-white border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200 appearance-none cursor-pointer text-sm" required>
                                    <option value="" class="text-gray-400">-- Pilih Format --</option>
                                    <option value="json" class="text-gray-800">
                                        📄 JSON (Lengkap)
                                    </option>
                                    <option value="csv" class="text-gray-800">
                                        📊 CSV (Excel Compatible)
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none mt-6">
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold py-2 px-3 rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center group text-sm">
                                <i class="fas fa-cloud-download-alt mr-1 group-hover:animate-bounce text-xs"></i>
                                Download Backup
                            </button>
                        </form>
                        
                        <div class="mt-2 text-xs text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Data akan diunduh dalam format yang dipilih
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- 3. Grafik Ringkas --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengeluaran 7 Hari Terakhir</h3>
                    <canvas id="weeklyExpenseChart"></canvas>
                </div>

                {{-- 4. Daftar Transaksi Terakhir --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terakhir</h3>
                    <div class="space-y-4">
                        @forelse ($transaksiTerakhir as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $item->kategoriJenis->jenis === 'Pemasukan' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        @if($item->kategoriJenis->jenis === 'Pemasukan')
                                            <i class="fa-solid fa-arrow-up"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->kategoriNama?->nama ?? 'Kategori Dihapus' }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="font-bold {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->kategoriJenis->jenis === 'Pemasukan' ? '+' : '-' }}Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">Belum ada transaksi.</p>
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
                const chartData = @json($chartData);
                const ctx = document.getElementById('weeklyExpenseChart');
                
                if (ctx && chartData.labels.length > 0) {
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                label: 'Total Pengeluaran',
                                data: chartData.data,
                                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 1,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>