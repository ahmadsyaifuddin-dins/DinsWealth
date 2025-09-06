<div id="showTabunganModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden p-4 overflow-y-auto">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-auto my-8 transform transition-all duration-300 max-h-[90vh] flex flex-col">
        
        {{-- Header Modal --}}
        <div class="flex justify-between items-center p-6 pb-4 border-b border-gray-100 dark:border-gray-700 flex-shrink-0">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                <i class="fa-solid fa-receipt mr-2 text-indigo-500"></i>
                Detail Transaksi
            </h3>
            <button onclick="closeShowModal()" class="text-gray-400 hover:text-gray-600 rounded-full p-2 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        {{-- Konten Detail - Scrollable --}}
        <div class="flex-1 overflow-y-auto p-8 space-y-6">
            {{-- Baris 1: Nominal & Jenis --}}
            <div class="text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Transaksi</p>
                <p id="showNominal" class="text-4xl font-bold"></p>
                <p id="showJenis" class="mt-1 text-lg font-medium"></p>
            </div>

            {{-- Baris 2: Info Utama --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Sumber Dana</p>
                    <p id="showNama" class="text-lg text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Tanggal Transaksi</p>
                    <p id="showTanggal" class="text-lg text-gray-900 dark:text-white"></p>
                </div>
            </div>

            {{-- Baris 3: Keterangan --}}
            <div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Keterangan</p>
                <div id="showKeterangan" class="prose prose-sm dark:prose-invert max-w-none bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg min-h-[60px]">
                    {{-- Keterangan akan diisi di sini --}}
                </div>
            </div>

            {{-- Baris 4: Galeri Bukti Transaksi --}}
            <div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Bukti Transaksi</p>
                <div id="showImagesContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg min-h-[100px]">
                    {{-- Gambar akan diisi oleh JavaScript di sini --}}
                </div>
            </div>
        </div>
    </div>
</div>