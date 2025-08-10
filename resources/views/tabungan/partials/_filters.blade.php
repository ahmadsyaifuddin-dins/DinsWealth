{{-- =============================================== --}}
{{-- KODE FORM FILTER DIMULAI DARI SINI --}}
{{-- =============================================== --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6">
    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
        <i class="fa-solid fa-filter mr-2"></i>
        Filter & Pencarian
    </h3>
    <form action="{{ route('tabungan.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

            {{-- Filter Tanggal Mulai --}}
            <div>
                <label for="tanggal_mulai" class="text-sm font-medium text-gray-700 dark:text-gray-200">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:ring-gray-600">
            </div>

            {{-- Filter Tanggal Selesai --}}
            <div>
                <label for="tanggal_selesai" class="text-sm font-medium text-gray-700 dark:text-gray-200">Sampai
                    Tanggal</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:ring-gray-600">
            </div>

            {{-- Filter Jenis (Pemasukan/Pengeluaran) --}}
            <div>
                <label for="jenis" class="text-sm font-medium text-gray-700 dark:text-gray-200">Jenis</label>
                <select name="jenis" id="jenis"
                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:ring-gray-600">
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
                <label for="kategori" class="text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
                <select name="kategori" id="kategori"
                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:ring-gray-600">
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
                <label for="search" class="text-sm font-medium text-gray-700 dark:text-gray-200">Kata Kunci</label>
                <input type="text" name="search" id="search" placeholder="Cari di keterangan..."
                    value="{{ request('search') }}"
                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:ring-gray-600 dark:placeholder-gray-400">
            </div>

        </div>
        
        {{-- Container tombol yang responsif --}}
        <div class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
            
            {{-- Tombol Reset --}}
            <a href="{{ route('tabungan.index') }}"
                class="flex items-center justify-center px-4 py-2.5 bg-gray-200 text-gray-800 font-medium text-sm rounded-lg hover:bg-gray-300 transition-all duration-200 min-w-[120px] dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                <i class="fa-solid fa-rotate mr-2 text-sm"></i>
                <span>Reset</span>
            </a>

            {{-- Tombol Filter --}}
            <button type="submit"
                class="flex items-center justify-center px-4 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition-all duration-200 min-w-[120px] dark:bg-indigo-700 dark:hover:bg-indigo-800">
                <i class="fa-solid fa-filter mr-2 text-sm"></i>
                <span>Filter</span>
            </button>
            
            {{-- Tombol Export PDF --}}
            <button type="button" id="exportPdfBtn"
                class="flex items-center justify-center px-4 py-2.5 bg-red-500 text-white font-medium text-sm rounded-lg hover:bg-red-600 transition-all duration-200 min-w-[120px] dark:bg-red-600 dark:hover:bg-red-700">
                <i class="fa-solid fa-file-pdf mr-2 text-sm"></i>
                <span>Export PDF</span>
            </button>

            {{-- Tombol Export Excel --}}
            <button type="button" id="exportExcelBtn"
                class="flex items-center justify-center px-4 py-2.5 bg-green-500 text-white font-medium text-sm rounded-lg hover:bg-green-600 transition-all duration-200 min-w-[120px] dark:bg-green-600 dark:hover:bg-green-700">
                <i class="fa-solid fa-file-excel mr-2 text-sm"></i>
                <span>Export Excel</span>
            </button>
            
        </div>
    </form>
</div>
{{-- =============================================== --}}
{{-- KODE FORM FILTER SELESAI --}}
{{-- =============================================== --}}