<div id="editTabunganModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden p-4 overflow-y-auto">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto my-8 transform transition-all duration-300 max-h-[90vh] flex flex-col">
        
        {{-- Header Modal - Fixed --}}
        <div class="flex justify-between items-center p-6 pb-4 border-b border-gray-100 flex-shrink-0">
            <h3 class="text-2xl font-bold text-gray-800">Edit Tabungan</h3>
            <button onclick="closeEditModal()" 
                class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
       
        {{-- Form Content - Scrollable --}}
        <div class="flex-1 overflow-y-auto">
            <form id="editTabunganForm" method="POST" action="" class="p-6">
                @csrf
                @method('PUT')
                
                {{-- Grid Form Fields --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Sumber Dana
                            </label>
                            <select id="edit_nama" name="nama" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                required>
                                @foreach($namaKategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="edit_jenis" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Transaksi
                            </label>
                            <select id="edit_jenis" name="jenis" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                required>
                                @foreach($jenisKategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="edit_nominal" class="block text-sm font-medium text-gray-700 mb-2">
                            Nominal
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="text" id="edit_nominal" name="nominal" 
                                class="w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                required onkeyup="formatNominal(this)" 
                                placeholder="0"
                                inputmode="numeric"
                            >
                        </div>
                    </div>
                    
                    <div>
                        <label for="edit_keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan <span class="text-gray-400 text-xs">(Opsional)</span>
                        </label>
                        <textarea id="edit_keterangan" name="keterangan" rows="4" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none" 
                            placeholder="Tambahkan keterangan untuk transaksi ini..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        {{-- Footer dengan Tombol - Fixed --}}
        <div class="flex-shrink-0 px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl">
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                <button type="button" onclick="closeEditModal()" 
                    class="w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200">
                    <i class="fa-solid fa-times mr-2"></i>
                    Batal
                </button>
                <button type="submit" form="editTabunganForm"
                    class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                    <i class="fa-solid fa-save mr-2"></i>
                    Update Tabungan
                </button>
            </div>
        </div>
        
    </div>
</div>

{{-- Tambahan CSS untuk smooth scrolling --}}
<style>
    #editTabunganModal .modal-content {
        animation: modalSlideIn 0.3s ease-out;
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
    
    /* Custom scrollbar untuk area form */
    #editTabunganModal .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    #editTabunganModal .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    #editTabunganModal .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    #editTabunganModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>