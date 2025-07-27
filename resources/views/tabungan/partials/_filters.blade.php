{{-- =============================================== --}}
{{-- KODE FORM FILTER DIMULAI DARI SINI --}}
{{-- =============================================== --}}
<div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">🔍 Filter & Pencarian</h3>
    <form action="{{ route('tabungan.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

            {{-- Filter Tanggal Mulai --}}
            <div>
                <label for="tanggal_mulai" class="text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Filter Tanggal Selesai --}}
            <div>
                <label for="tanggal_selesai" class="text-sm font-medium text-gray-700">Sampai
                    Tanggal</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Filter Jenis (Pemasukan/Pengeluaran) --}}
            <div>
                <label for="jenis" class="text-sm font-medium text-gray-700">Jenis</label>
                <select name="jenis" id="jenis"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisKategori as $kat)
                    <option value="{{ $kat->id }}" {{ request('jenis')==$kat->id ? 'selected' : '' }}>
                        {{ $kat->jenis }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Kategori (Sumber Dana) --}}
            <div>
                <label for="kategori" class="text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Kategori</option>
                    @foreach($namaKategori as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori')==$kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Pencarian Kata Kunci --}}
            <div>
                <label for="search" class="text-sm font-medium text-gray-700">Kata Kunci</label>
                <input type="text" name="search" id="search" placeholder="Cari di keterangan..."
                    value="{{ request('search') }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

        </div>
        <div class="mt-4 flex items-center justify-end space-x-2">

            <a href="{{ route('tabungan.index') }}"
                class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-all"> <i
                    class="fa-solid fa-rotate mr-2"></i> Reset</a>
            <button type="submit"
                class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition-all"> <i
                    class="fa-solid fa-filter mr-2"></i> Filter
            </button>
            {{-- Tombol Export PDF BARU --}}
            <button type="button" id="exportPdfBtn"
                class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 transition-all"> <i
                    class="fa-solid fa-file-pdf mr-2"></i> Export PDF</button>

            {{-- Tombol Export Excel BARU --}}
            <button type="button" id="exportExcelBtn"
                class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition-all"> <i
                    class="fa-solid fa-file-excel mr-2"></i>Export Excel</button>
        </div>
    </form>
</div>
{{-- =============================================== --}}
{{-- KODE FORM FILTER SELESAI --}}
{{-- =============================================== --}}