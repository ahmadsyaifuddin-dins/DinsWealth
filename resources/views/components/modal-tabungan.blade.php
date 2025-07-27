<div id="tabunganModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 overflow-y-auto">
    <div class="min-h-full flex items-center justify-center p-4 py-8">
        <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-lg relative transform transition-all duration-300 scale-95 opacity-0 my-8">
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-2xl p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white bg-opacity-10 rounded-full -ml-12 -mb-12"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Tambah Tabungan</h2>
                            <p class="text-indigo-100 text-sm">Masukkan detail transaksi baru</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal()" class="w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg flex items-center justify-center transition-all duration-200 group">
                        <svg class="w-5 h-5 text-white group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-8">
            <form method="POST" action="{{ route('tabungan.store') }}" class="space-y-6">
                @csrf
                
                <!-- Nama Tabungan -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-semibold mb-3 flex items-center" for="nama">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Nama Tabungan
                    </label>
                    <div class="relative">
                        <select name="nama" id="nama" class="w-full py-3 px-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 transition-all duration-300 appearance-none cursor-pointer">
                            @foreach ($namaKategori as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Jenis Tabungan -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-semibold mb-3 flex items-center" for="jenis">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Jenis Tabungan
                    </label>
                    <div class="relative">
                        <select name="jenis" id="jenis" class="w-full py-3 px-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 transition-all duration-300 appearance-none cursor-pointer">
                            @foreach ($jenisKategori as $kategori)
                                <option value="{{ $kategori->id }}" class="{{ $kategori->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $kategori->jenis === 'Pemasukan' ? '↗️' : '↘️' }} {{ $kategori->jenis }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Nominal -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-semibold mb-3 flex items-center" for="nominal">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Jumlah Nominal
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input
                            type="text"
                            name="nominal"
                            id="nominal"
                            class="w-full py-3 pl-12 pr-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-green-500 transition-all duration-300 font-medium"
                            placeholder="0"
                            oninput="formatNominal(this)"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 ml-1">Format otomatis: 1.000.000</p>
                </div>

                <!-- Keterangan -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-semibold mb-3 flex items-center" for="keterangan">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Keterangan 
                        <span class="text-gray-400 text-xs ml-1">(opsional)</span>
                    </label>
                    <textarea
                        name="keterangan"
                        id="keterangan"
                        rows="3"
                        class="w-full py-3 px-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500 transition-all duration-300 resize-none"
                        placeholder="Tambahkan catatan untuk transaksi ini..."
                    ></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Tabungan</span>
                    </button>
                </div>
            </form>
        </div>
            </div>
    </div>
</div>

<style>
    /* Modal Animation */
    #tabunganModal:not(.hidden) .modal-content {
        animation: modalSlideIn 0.3s ease-out forwards;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Custom Select Styling */
    select:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Input Focus Animation */
    .group:focus-within label {
        color: #6366f1;
    }

    /* Textarea auto-resize */
    textarea {
        min-height: 80px;
        field-sizing: content;
    }

    /* Button Loading State */
    button[type="submit"]:active {
        transform: scale(0.98);
    }

    /* Mobile Responsive */
    @media (max-width: 640px) {
        .modal-content {
            margin: 0.5rem;
        }
        
        #tabunganModal .min-h-full {
            min-height: 100vh;
            padding: 1rem 0.5rem;
        }
    }
</style>

<script>
    // Enhanced modal functions
    function openModal() {
        const modal = document.getElementById('tabunganModal');
        const modalContent = modal.querySelector('.modal-content');
        
        modal.classList.remove('hidden');
        
        // Add entrance animation
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Focus first input
        setTimeout(() => {
            document.getElementById('nama').focus();
        }, 300);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('tabunganModal');
        const modalContent = modal.querySelector('.modal-content');
        
        // Add exit animation
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            // Reset form
            modal.querySelector('form').reset();
            // Restore body scroll
            document.body.style.overflow = '';
        }, 300);
    }

    // Close modal when clicking outside
    document.getElementById('tabunganModal').addEventListener('click', function(e) {
        if (e.target === this || e.target.classList.contains('min-h-full')) {
            closeModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('tabunganModal').classList.contains('hidden')) {
            closeModal();
        }
    });

    // Enhanced nominal formatting
    function formatNominal(input) {
        let value = input.value.replace(/\D/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }
        
        // Add visual feedback
        const indicator = input.parentElement.querySelector('.bg-green-400');
        if (indicator) {
            indicator.classList.remove('animate-pulse');
            indicator.classList.add('animate-bounce');
            setTimeout(() => {
                indicator.classList.remove('animate-bounce');
                indicator.classList.add('animate-pulse');
            }, 500);
        }
    }

    // Auto-resize textarea
    document.addEventListener('input', function(e) {
        if (e.target.tagName.toLowerCase() === 'textarea') {
            e.target.style.height = 'auto';
            e.target.style.height = e.target.scrollHeight + 'px';
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const nominal = document.getElementById('nominal').value;
        if (!nominal.trim()) {
            e.preventDefault();
            alert('Harap masukkan jumlah nominal!');
            document.getElementById('nominal').focus();
            return false;
        }
    });
</script>