<div class="mb-6 bg-white shadow-sm sm:rounded-lg p-4">
    <form method="GET" action="{{ route('planned-transactions.index') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700">Cari Keterangan</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari keterangan..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label for="nama" class="block text-sm font-medium text-gray-700">Kategori Nama</label>
            <select name="nama" id="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                <option value="">Semua</option>
                @foreach (\App\Models\KategoriNamaTabungan::all() as $kategoriNama)
                    <option value="{{ $kategoriNama->id }}" {{ request('nama') == $kategoriNama->id ? 'selected' : '' }}>
                        {{ $kategoriNama->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[150px]">
            <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis</label>
            <select name="jenis" id="jenis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                <option value="">Semua</option>
                @foreach (\App\Models\KategoriJenisTabungan::all() as $kategoriJenis)
                    <option value="{{ $kategoriJenis->id }}" {{ request('jenis') == $kategoriJenis->id ? 'selected' : '' }}>
                        {{ $kategoriJenis->jenis }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[120px]">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                <option value="">Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="flex-1 min-w-[150px]">
            <label for="jatuh_tempo_start" class="block text-sm font-medium text-gray-700">Jatuh Tempo (Dari)</label>
            <input type="date" name="jatuh_tempo_start" id="jatuh_tempo_start" value="{{ request('jatuh_tempo_start') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label for="jatuh_tempo_end" class="block text-sm font-medium text-gray-700">Jatuh Tempo (Sampai)</label>
            <input type="date" name="jatuh_tempo_end" id="jatuh_tempo_end" value="{{ request('jatuh_tempo_end') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
        </div>
        <div class="flex items-end space-x-2">
            <button type="submit" class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none">
                Filter
            </button>
            <a href="{{ route('planned-transactions.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none">
                Reset
            </a>
        </div>
    </form>
</div>