<div class="group relative flex items-center justify-between p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl hover:from-gray-100 hover:to-gray-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg
    dark:bg-gradient-to-r dark:from-slate-800 dark:to-gray-900 dark:hover:from-gray-900 dark:hover:to-gray-800">

    <!-- Transaction Icon and Info -->
    <div class="flex items-center flex-1">
        <div class="relative w-12 h-12 rounded-2xl flex items-center justify-center mr-4 shadow-lg 
            {{ $item->kategoriJenis->jenis === 'Pemasukan' 
                ? 'bg-gradient-to-br from-green-500 to-emerald-600 dark:from-green-700 dark:to-emerald-900' 
                : 'bg-gradient-to-br from-red-500 to-pink-600 dark:from-red-700 dark:to-pink-900' }}">
            @if($item->kategoriJenis->jenis === 'Pemasukan')
                <i class="fa-solid fa-arrow-up text-white text-lg"></i>
            @else
                <i class="fa-solid fa-arrow-down text-white text-lg"></i>
            @endif
            
            <!-- Badge for transaction order -->
            <div class="absolute -top-2 -right-2 bg-white text-gray-600 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-lg dark:bg-slate-700 dark:text-gray-200">
                {{ $index + 1 }}
            </div>
        </div>
        
        <div class="flex-1">
            <p class="font-bold text-gray-900 dark:text-gray-100 text-sm mb-1">
                {{ $item->kategoriNama?->nama ?? 'Kategori Dihapus' }}
            </p>
            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400
                        sm:flex-row flex-col gap-0 sm:gap-0">
                <i class="fas fa-clock mr-1 sm:mb-0 mb-1 text-[12px] sm:text-xs"></i>
                <span class="sm:ml-0">{{ $item->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    
    <!-- Amount -->
    <div class="text-right ml-4">
        <p class="font-bold text-lg 
            {{ $item->kategoriJenis?->jenis === 'Pemasukan' 
                ? 'text-green-600 dark:text-emerald-300' 
                : 'text-red-600 dark:text-pink-300' }}">
            {{ $item->kategoriJenis->jenis === 'Pemasukan' ? '+' : '-' }}{{ App\Helpers\DashboardGreetingHelper::formatRupiah($item->nominal) }}
        </p>
        <div class="flex items-center justify-end mt-1">
            <div class="w-2 h-2 rounded-full 
                {{ $item->kategoriJenis->jenis === 'Pemasukan' 
                    ? 'bg-green-400 dark:bg-emerald-400' 
                    : 'bg-red-400 dark:bg-pink-400' }}"></div>
            <span class="ml-2 text-xs text-gray-400 dark:text-gray-300 font-medium">
                {{ $item->kategoriJenis->jenis }}
            </span>
        </div>
    </div>
</div>