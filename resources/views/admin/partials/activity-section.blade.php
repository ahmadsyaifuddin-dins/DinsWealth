<div
    class="bg-white rounded-3xl shadow-xl border border-gray-100 dark:bg-slate-800 dark:border-slate-700 overflow-hidden transition-colors duration-300">

    <!-- Padding responsif: p-5 di mobile, p-8 di desktop -->
    <div class="p-5 sm:p-8">

        <!-- Activity Header -->
        @include('admin.partials.activity-header')

        <!-- Activity List -->
        <div class="space-y-4 max-h-[400px] overflow-y-auto custom-scrollbar pr-2 scroll-smooth">
            @forelse ($transaksiTerakhir as $index => $item)
                @include('admin.partials.activity-item', ['item' => $item, 'index' => $index])
            @empty
                @include('admin.partials.activity-empty')
            @endforelse
        </div>

        <!-- View All Button -->
        @if ($transaksiTerakhir->count() > 0)
            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                <a href="{{ route('tabungan.index') }}"
                    class="group block text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-3.5 px-4 rounded-2xl transition-all duration-300 dark:bg-slate-700/50 dark:hover:bg-slate-700 dark:text-gray-300 border border-gray-200 dark:border-slate-600">
                    <span class="flex items-center justify-center gap-2 group-hover:gap-3 transition-all">
                        <i
                            class="fas fa-list text-gray-500 dark:text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                        <span>Lihat Semua Transaksi</span>
                        <i
                            class="fas fa-arrow-right text-xs opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all text-blue-500"></i>
                    </span>
                </a>
            </div>
        @endif
    </div>
</div>
