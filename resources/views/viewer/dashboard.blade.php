<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg p-6 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Dashboard Keuangan (View Only)
            </h2>
            <p class="text-emerald-100 mt-2">Selamat datang, {{ Auth::user()->name }}. Anda memiliki akses untuk melihat data.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. Kartu Ringkasan Utama --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <p class="text-gray-500">Saldo Total Saat Ini</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">Rp{{ number_format($saldoSaatIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <p class="text-gray-500">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">Rp{{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <p class="text-gray-500">Pengeluaran Bulan Ini</p>
                    <p class="text-2xl font-bold text-red-600 mt-2">Rp{{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- 2. Grafik Pie Chart --}}
                <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Komposisi Bulan Ini</h3>
                    <canvas id="monthlyCompositionChart"></canvas>
                </div>

                {{-- 3. Daftar Transaksi Terakhir --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terakhir</h3>
                        <a href="{{ route('tabungan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">Lihat Semua &rarr;</a>
                    </div>
                    <div class="space-y-4">
                        @forelse ($transaksiTerakhir as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $item->kategoriJenis->jenis === 'Pemasukan' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        @if($item->kategoriJenis->jenis === 'Pemasukan') <i class="fa-solid fa-arrow-up"></i> @else <i class="fa-solid fa-arrow-down"></i> @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->kategoriNama?->nama ?? 'Kategori Dihapus' }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="font-bold {{ $item->kategoriJenis->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartData = @json($chartData);
                const ctx = document.getElementById('monthlyCompositionChart');

                if (ctx && (chartData.pemasukan > 0 || chartData.pengeluaran > 0)) {
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Pemasukan', 'Pengeluaran'],
                            datasets: [{
                                data: [chartData.pemasukan, chartData.pengeluaran],
                                backgroundColor: ['rgba(16, 185, 129, 0.8)', 'rgba(239, 68, 68, 0.8)'],
                                borderColor: ['#ffffff'],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            }
                        }
                    });
                } else if(ctx) {
                    ctx.getContext('2d').fillText("Belum ada data bulan ini.", ctx.width / 2 - 50, ctx.height / 2);
                }
            });
        </script>
    @endpush
</x-app-layout>