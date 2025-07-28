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
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl shadow-lg p-6">
                    <p class="text-indigo-100">Saldo Saat Ini</p>
                    <p class="text-3xl font-bold mt-2">Rp{{ number_format($saldoSaatIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <p class="text-gray-500">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">Rp{{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                </div>
                
                {{-- 2. Tombol Aksi Cepat --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-center space-y-3">
                    <a href="{{ route('tabungan.index') }}" class="w-full text-center bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition-all">
                        Kelola Tabungan
                    </a>
                    <button onclick="openModal()" class="w-full text-center bg-gray-200 text-gray-800 font-bold py-3 px-4 rounded-lg hover:bg-gray-300 transition-all">
                        + Tambah Transaksi Cepat
                    </button>
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
    @include('components.modal-tabungan')
    
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