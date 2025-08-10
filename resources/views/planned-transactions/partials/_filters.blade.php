<div class="mb-6 bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/50 sm:rounded-lg border border-gray-200 dark:border-gray-700 p-4 md:p-6 transition-colors duration-200">
    <div class="mb-4 flex items-center space-x-2">
        <i class="fa-solid fa-filter text-gray-600 dark:text-gray-400"></i>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Filter Transaksi</h3>
    </div>
    
    <form method="GET" action="{{ route('planned-transactions.index') }}" class="flex flex-wrap items-end gap-4">
        {{-- Search Input --}}
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fa-solid fa-magnifying-glass mr-1 text-gray-500 dark:text-gray-400"></i>
                Cari Keterangan
            </label>
            <input type="text" 
                   name="search" 
                   id="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari keterangan..." 
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500/20 placeholder-gray-400 dark:placeholder-gray-500 text-sm transition-colors duration-200">
        </div>

        {{-- Kategori Nama Select --}}
        <div class="flex-1 min-w-[150px]">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fa-solid fa-tag mr-1 text-gray-500 dark:text-gray-400"></i>
                Kategori Nama
            </label>
            <select name="nama" 
                    id="nama" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500/20 text-sm transition-colors duration-200">
                <option value="" class="text-gray-500 dark:text-gray-400">Semua Kategori</option>
                @foreach (\App\Models\KategoriNamaTabungan::all() as $kategoriNama)
                    <option value="{{ $kategoriNama->id }}" 
                            {{ request('nama') == $kategoriNama->id ? 'selected' : '' }}
                            class="text-gray-900 dark:text-gray-100">
                        {{ $kategoriNama->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Jenis Select --}}
        <div class="flex-1 min-w-[150px]">
            <label for="jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fa-solid fa-list mr-1 text-gray-500 dark:text-gray-400"></i>
                Jenis
            </label>
            <select name="jenis" 
                    id="jenis" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500/20 text-sm transition-colors duration-200">
                <option value="" class="text-gray-500 dark:text-gray-400">Semua Jenis</option>
                @foreach (\App\Models\KategoriJenisTabungan::all() as $kategoriJenis)
                    <option value="{{ $kategoriJenis->id }}" 
                            {{ request('jenis') == $kategoriJenis->id ? 'selected' : '' }}
                            class="text-gray-900 dark:text-gray-100">
                        <span class="inline-flex items-center">
                            @if($kategoriJenis->jenis === 'Pemasukan')
                                ↗ {{ $kategoriJenis->jenis }}
                            @else
                                ↘ {{ $kategoriJenis->jenis }}
                            @endif
                        </span>
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status Select --}}
        <div class="flex-1 min-w-[120px]">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fa-solid fa-circle-check mr-1 text-gray-500 dark:text-gray-400"></i>
                Status
            </label>
            <select name="status" 
                    id="status" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500/20 text-sm transition-colors duration-200">
                <option value="" class="text-gray-500 dark:text-gray-400">Semua Status</option>
                <option value="pending" 
                        {{ request('status') == 'pending' ? 'selected' : '' }}
                        class="text-yellow-700 dark:text-yellow-300">
                    🕒 Pending
                </option>
                <option value="done" 
                        {{ request('status') == 'done' ? 'selected' : '' }}
                        class="text-green-700 dark:text-green-300">
                    ✅ Selesai
                </option>
            </select>
        </div>

        {{-- Date From Input --}}
        <div class="flex-1 min-w-[150px]">
            <label for="jatuh_tempo_start" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fa-solid fa-calendar-days mr-1 text-gray-500 dark:text-gray-400"></i>
                Dari Tanggal
            </label>
            <input type="date" 
                   name="jatuh_tempo_start" 
                   id="jatuh_tempo_start" 
                   value="{{ request('jatuh_tempo_start') }}" 
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500/20 text-sm transition-colors duration-200">
        </div>

        {{-- Date To Input --}}
        <div class="flex-1 min-w-[150px]">
            <label for="jatuh_tempo_end" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fa-solid fa-calendar-check mr-1 text-gray-500 dark:text-gray-400"></i>
                Sampai Tanggal
            </label>
            <input type="date" 
                   name="jatuh_tempo_end" 
                   id="jatuh_tempo_end" 
                   value="{{ request('jatuh_tempo_end') }}" 
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-500/20 text-sm transition-colors duration-200">
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-end space-x-3 min-w-[160px]">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 active:bg-indigo-800 dark:active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm">
                <i class="fa-solid fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('planned-transactions.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm">
                <i class="fa-solid fa-rotate-left mr-2"></i>
                Reset
            </a>
        </div>
    </form>

    {{-- Active Filters Display --}}
    @if(request()->hasAny(['search', 'nama', 'jenis', 'status', 'jatuh_tempo_start', 'jatuh_tempo_end']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    <i class="fa-solid fa-tags mr-1"></i>
                    Filter Aktif:
                </span>
                
                @if(request('search'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                        <i class="fa-solid fa-magnifying-glass mr-1"></i>
                        "{{ request('search') }}"
                    </span>
                @endif
                
                @if(request('nama'))
                    @php
                        $kategoriNama = \App\Models\KategoriNamaTabungan::find(request('nama'));
                    @endphp
                    @if($kategoriNama)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-700">
                            <i class="fa-solid fa-tag mr-1"></i>
                            {{ $kategoriNama->nama }}
                        </span>
                    @endif
                @endif
                
                @if(request('jenis'))
                    @php
                        $kategoriJenis = \App\Models\KategoriJenisTabungan::find(request('jenis'));
                    @endphp
                    @if($kategoriJenis)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-700">
                            <i class="fa-solid fa-list mr-1"></i>
                            {{ $kategoriJenis->jenis }}
                        </span>
                    @endif
                @endif
                
                @if(request('status'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ request('status') == 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-700' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-700' }} border">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        {{ request('status') == 'pending' ? 'Pending' : 'Selesai' }}
                    </span>
                @endif
                
                @if(request('jatuh_tempo_start') || request('jatuh_tempo_end'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-700">
                        <i class="fa-solid fa-calendar-days mr-1"></i>
                        @if(request('jatuh_tempo_start') && request('jatuh_tempo_end'))
                            {{ \Carbon\Carbon::parse(request('jatuh_tempo_start'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('jatuh_tempo_end'))->format('d/m/Y') }}
                        @elseif(request('jatuh_tempo_start'))
                            Dari {{ \Carbon\Carbon::parse(request('jatuh_tempo_start'))->format('d/m/Y') }}
                        @else
                            Sampai {{ \Carbon\Carbon::parse(request('jatuh_tempo_end'))->format('d/m/Y') }}
                        @endif
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>