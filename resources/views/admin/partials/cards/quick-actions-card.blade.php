<div class="group relative bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
    <div class="text-center mb-4">
        <div class="bg-gradient-to-br from-purple-500 to-pink-600 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-bolt text-white text-xl"></i>
        </div>
        <h3 class="font-bold text-gray-800 text-lg">Quick Actions</h3>
        <p class="text-gray-500 text-xs mt-1">Aksi Cepat</p>
    </div>
    
    <div class="space-y-3">
        <a href="{{ route('tabungan.index') }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-wallet mr-2"></i>Kelola Tabungan
        </a>
        
        <button onclick="openModal()" class="w-full text-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
        </button>
    </div>
</div>