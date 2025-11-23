@php
    // Logic Pemasukan/Pengeluaran
    $isPemasukan = $item->kategoriJenis->jenis === 'Pemasukan';

    // Setup Warna & Icon berdasarkan tipe
    $gradientIcon = $isPemasukan
        ? 'from-green-500 to-emerald-600 shadow-green-500/30'
        : 'from-rose-500 to-pink-600 shadow-rose-500/30';

    $textAmount = $isPemasukan ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400';

    $iconClass = $isPemasukan ? 'fa-arrow-up' : 'fa-arrow-down';
    $sign = $isPemasukan ? '+' : '-';
@endphp

<div
    class="group relative flex items-center justify-between p-3 sm:p-4 mb-3 bg-white dark:bg-slate-800/50 rounded-2xl border border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all duration-300">

    <!-- Left Side: Icon & Main Info -->
    <div class="flex items-center gap-3 sm:gap-4 overflow-hidden flex-1">

        <!-- Icon Box (Fixed Size) -->
        <div
            class="relative flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br {{ $gradientIcon }} flex items-center justify-center shadow-lg transition-transform group-hover:scale-110">
            <i class="fa-solid {{ $iconClass }} text-white text-sm sm:text-base"></i>
        </div>

        <!-- Text Info (Fluid Width with Truncate) -->
        <div class="flex flex-col min-w-0">
            <!-- Nama Kategori -->
            <h4 class="text-sm sm:text-base font-bold text-gray-800 dark:text-gray-100 truncate">
                {{ $item->kategoriNama?->nama ?? 'Kategori Dihapus' }}
            </h4>

            <!-- Detail: Keterangan & Waktu -->
            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                <!-- Keterangan (Dipotong otomatis di mobile) -->
                <span class="truncate max-w-[120px] sm:max-w-xs block">
                    {{ $item->keterangan ?? '-' }}
                </span>

                <!-- Dot Separator -->
                <span class="w-1 h-1 bg-gray-300 rounded-full flex-shrink-0"></span>

                <!-- Waktu -->
                <span class="flex-shrink-0 whitespace-nowrap">
                    {{ $item->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>

    <!-- Right Side: Amount -->
    <div class="text-right pl-3 flex-shrink-0">
        <p class="font-bold text-sm sm:text-lg {{ $textAmount }} whitespace-nowrap">
            {{ $sign }} {{ App\Helpers\DashboardGreetingHelper::formatRupiah($item->nominal) }}
        </p>

        <!-- Label Jenis (Hidden di HP super kecil, muncul di SM ke atas) -->
        <div class="hidden sm:flex items-center justify-end mt-1 gap-1">
            <div class="w-1.5 h-1.5 rounded-full {{ $isPemasukan ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
            <span class="text-[10px] uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold">
                {{ $item->kategoriJenis->jenis }}
            </span>
        </div>
    </div>
</div>
