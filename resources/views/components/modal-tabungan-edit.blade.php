<div id="editTabunganModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-8 transform transition-all duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Edit Tabungan</h3>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
        </div>
        
        <form id="editTabunganForm" method="POST" action=""> @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">Sumber Dana</label>
                    <select id="edit_nama" name="nama" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @foreach($namaKategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="edit_jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                    <select id="edit_jenis" name="jenis" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @foreach($jenisKategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label for="edit_nominal" class="block text-sm font-medium text-gray-700 mb-2">Nominal</label>
                <input type="text" id="edit_nominal" name="nominal" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required onkeyup="formatNominal(this)">
            </div>

            <div class="mt-6">
                <label for="edit_keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                <textarea id="edit_keterangan" name="keterangan" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="mt-8 text-right">
                <button type="button" onclick="closeEditModal()" class="bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-xl mr-2 hover:bg-gray-300 transition-all">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 transition-all">
                    Update Tabungan
                </button>
            </div>
        </form>
    </div>
</div>