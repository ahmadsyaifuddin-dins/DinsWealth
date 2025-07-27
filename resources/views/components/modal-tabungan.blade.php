<div id="tabunganModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <h2 class="text-xl font-bold mb-4">Input Tabungan Baru</h2>

        <form method="POST" action="{{ route('admin.tabungan.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                    Nama Tabungan
                </label>
                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring"
                    placeholder="Masukkan nama tabungan"
                >
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis">
                    Jenis Tabungan
                </label>
                <select name="jenis" id="jenis" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring">
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                    Jumlah Nominal
                </label>
                <input
                    type="text"
                    name="nominal"
                    id="nominal"
                    class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring"
                    placeholder="Masukkan jumlah (cth: 10000)"
                    oninput="formatNominal(this)"
                >
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="keterangan">
                    Keterangan (opsional)
                </label>
                <input
                    type="text"
                    name="keterangan"
                    id="keterangan"
                    class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring"
                >
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
