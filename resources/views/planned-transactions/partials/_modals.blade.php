<div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Rencana Transaksi</h3>
        <form action="{{ route('planned-transactions.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="create_keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <input type="text" name="keterangan" id="create_keterangan" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="create_nama" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="nama" id="create_nama" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($namaKategori as $kat) <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="create_jenis" class="block text-sm font-medium text-gray-700">Jenis</label>
                        <select name="jenis" id="create_jenis" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($jenisKategori as $kat) <option value="{{ $kat->id }}">{{ $kat->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="create_nominal" class="block text-sm font-medium text-gray-700">Nominal</label>
                        <input type="text" id="create_nominal" required
                            inputmode="numeric"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="100.000">
                        <input type="hidden" name="nominal" id="create_nominal_raw">
                    </div>
                    <div>
                        <label for="create_jatuh_tempo" class="block text-sm font-medium text-gray-700">Jatuh
                            Tempo</label>
                        <input type="date" name="jatuh_tempo" id="create_jatuh_tempo" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>
            <div class="mt-6 text-right space-x-2">
                <button type="button" onclick="closeCreateModal()"
                    class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit"
                    class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-700">Simpan
                    Rencana</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Rencana Transaksi</h3>
        <form id="editForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <input type="text" name="keterangan" id="edit_keterangan" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_nama" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="nama" id="edit_nama" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($namaKategori as $kat) <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_jenis" class="block text-sm font-medium text-gray-700">Jenis</label>
                        <select name="jenis" id="edit_jenis" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($jenisKategori as $kat) <option value="{{ $kat->id }}">{{ $kat->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_nominal" class="block text-sm font-medium text-gray-700">Nominal</label>
                        <input type="text" id="edit_nominal" required
                            inputmode="numeric"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <input type="hidden" name="nominal" id="edit_nominal_raw">
                    </div>
                    <div>
                        <label for="edit_jatuh_tempo" class="block text-sm font-medium text-gray-700">Jatuh
                            Tempo</label>
                        <input type="date" name="jatuh_tempo" id="edit_jatuh_tempo" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                {{-- =============================================== --}}
                {{-- BAGIAN YANG HILANG - TAMBAHKAN INI --}}
                {{-- =============================================== --}}
                <div>
                    <label for="edit_tanggal_peristiwa" class="block text-sm font-medium text-gray-700">Tanggal & Waktu
                        Peristiwa (Opsional)</label>
                    <input type="datetime-local" name="tanggal_peristiwa" id="edit_tanggal_peristiwa"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika belum terjadi.</p>
                </div>
            </div>
            <div class="mt-6 text-right space-x-2">
                <button type="button" onclick="closeEditModal()"
                    class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit"
                    class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-700">Update
                    Rencana</button>
            </div>
        </form>
    </div>
</div>

<div id="completeModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Konfirmasi Realisasi Transaksi</h3>
            <button onclick="closeCompleteModal()" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        </div>
        <div class="mb-4 p-4 bg-gray-50 rounded-lg border">
            <p class="text-sm text-gray-600">Anda akan menyelesaikan rencana:</p>
            <p id="completeModalInfo" class="text-lg font-bold text-gray-900 mt-1"></p>
        </div>
        <form id="completeForm" method="POST" action="">
            @csrf
            <div>
                <label for="tanggal_peristiwa" class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu
                    Peristiwa</label>
                <input type="datetime-local" name="tanggal_peristiwa" id="tanggal_peristiwa" required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Otomatis diisi dengan waktu sekarang (bisa diubah).</p>
            </div>
            <div class="mt-6 text-right">
                <button type="button" onclick="closeCompleteModal()"
                    class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</button>
                <button type="submit"
                    class="bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700">Konfirmasi &
                    Catat</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal for Read More --}}
<div id="readMoreModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detail Keterangan</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500" id="readMoreDescription"></p>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeReadMoreModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>