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