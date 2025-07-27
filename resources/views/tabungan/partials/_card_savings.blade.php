<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Total Pemasukan --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        <div class="bg-green-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pemasukan</p>
            <p class="text-2xl font-bold text-green-600">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
            </p>
        </div>
    </div>
    {{-- Total Pengeluaran --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        <div class="bg-red-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-600">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}
            </p>
        </div>
    </div>
    {{-- Saldo Akhir --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        <div class="bg-indigo-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 6l3 6h12l3-6H3zM3 18h18"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Saldo Akhir</p>
            <p class="text-2xl font-bold text-indigo-600">Rp{{ number_format($saldoAkhir, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>