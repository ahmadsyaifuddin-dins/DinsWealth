{{-- Kita ubah gridnya jadi 2 kolom di medium, dan 4 kolom di large --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- Total Transaksi --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        {{-- Kita pakai ikon dan warna baru (biru) --}}
        <div class="bg-blue-100 dark:bg-blue-200 p-3 rounded-full">
            <i class="fa-solid fa-receipt text-blue-600 dark:text-blue-700"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
            <p
                class="text-2xl font-bold text-blue-600 dark:text-blue-500 dark:drop-shadow-[0_0_10px_rgba(255,255,200,0.3)]">
                {{-- Tampilkan variabel $totalTransaksi --}}
                {{ number_format($totalTransaksi, 0, ',', '.') }}
            </p>
        </div>
    </div>
    {{-- Total Pemasukan --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        <div class="bg-green-100 dark:bg-green-200 p-3 rounded-full">
            <i class="fa-solid fa-plus text-green-600 dark:text-green-700"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pemasukan</p>
            <p
                class="text-2xl font-bold text-green-600 dark:text-green-500 dark:drop-shadow-[0_0_10px_rgba(255,255,200,0.3)]">
                Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Total Pengeluaran --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        <div class="bg-red-100 dark:bg-red-200 p-3 rounded-full">
            <i class="fa-solid fa-minus text-red-600 dark:text-red-700"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengeluaran</p>
            <p
                class="text-2xl font-bold text-red-600 dark:text-red-500 dark:drop-shadow-[0_0_10px_rgba(255,255,200,0.3)]">
                Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Saldo Akhir --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex items-center space-x-4">
        <div class="bg-indigo-100 dark:bg-indigo-200 p-3 rounded-full">
            <i class="fa-solid fa-coins text-indigo-600 dark:text-indigo-700"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Akhir</p>
            <p
                class="text-2xl font-bold text-indigo-600 dark:text-indigo-500 dark:drop-shadow-[0_0_10px_rgba(255,255,200,0.3)]">
                Rp{{ number_format($saldoAkhir, 0, ',', '.') }}
            </p>
        </div>
    </div>

</div>