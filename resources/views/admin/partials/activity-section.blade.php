<div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
    
    <!-- Activity Header -->
    @include('admin.partials.activity-header')
    
    <!-- Activity List -->
    <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
        @forelse ($transaksiTerakhir as $index => $item)
            @include('admin.partials.activity-item', ['item' => $item, 'index' => $index])
        @empty
            @include('admin.partials.activity-empty')
        @endforelse
    </div>
    
    <!-- View All Button -->
    @if($transaksiTerakhir->count() > 0)
        <div class="mt-6 pt-6 border-t border-gray-100">
            <a href="{{ route('tabungan.index') }}" class="block text-center bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-2xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-list mr-2"></i>Lihat Semua Transaksi
            </a>
        </div>
    @endif
</div>