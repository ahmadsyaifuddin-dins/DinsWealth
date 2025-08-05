<div class="bg-white rounded-xl md:rounded-2xl shadow-xl overflow-hidden">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 md:p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h3 class="font-bold text-xl md:text-2xl text-white mb-1 md:mb-2">💰 Semua Tabungan</h3>
                <p class="text-indigo-100 text-sm md:text-base">Pantau semua transaksi keuangan Anda</p>
            </div>
            <button
                class="bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-2 md:py-3 px-4 md:px-6 rounded-lg md:rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center w-full sm:w-auto"
                onclick="openModal()">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="text-sm md:text-base">Tambah Tabungan</span>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 md:p-8">
        @if (count($data) > 0)
        <div class="grid gap-3 md:gap-4">
            @foreach ($data as $item)
            <div
                class="group bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-lg md:rounded-xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:border-indigo-200">
                <div
                    class="flex flex-col md:flex-row md:justify-between md:items-start space-y-4 md:space-y-0">
                    <div class="flex-1">
                        <div class="flex items-start md:items-center mb-3">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                                @if ($item->kategoriJenis?->jenis === 'Pemasukan')
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 11l5-5m0 0l5 5m-5-5v12">
                                    </path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 13l-5 5m0 0l-5-5m5 5V6">
                                    </path>
                                </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-lg md:text-xl text-gray-800 break-words">
                                    {{ $item->kategoriNama->nama ?? 'Tidak diketahui' }}
                                </h4>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 mt-1 space-y-1 sm:space-y-0">
                                    <span
                                        class="inline-flex items-center px-2 md:px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($item->kategoriJenis?->jenis ?? 'Tidak diketahui') }}
                                    </span>
                                    <!-- Tanggal dan Waktu -->
                                    <div class="flex items-center text-xs text-gray-800 space-x-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($item->keterangan && $item->keterangan !== '-')
                        <div class="bg-gray-50 rounded-lg p-3 mt-3">
                            <p class="text-sm text-gray-600 break-words">
                                <span class="font-medium">Keterangan:</span>
                                {{ $item->keterangan }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Mobile: Amount and Actions Stacked -->
                    <div
                        class="flex flex-col md:flex-row md:items-start space-y-3 md:space-y-0 md:space-x-4">
                        <!-- Amount Section -->
                        <div class="text-center md:text-right">
                            <p
                                class="text-xl md:text-2xl font-bold {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }} break-all">
                                {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? '+' : '-' }}Rp{{
                                number_format($item->nominal, 0, ',', '.') }}
                            </p>
                            <!-- Tanggal dan Waktu di bawah nominal (untuk tampilan mobile) -->
                            <div class="md:hidden mt-2">
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div
                                class="w-12 md:w-16 h-1 {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-400' : 'bg-red-400' }} rounded-full mt-2 mx-auto md:ml-auto">
                            </div>
                        </div>

                        <!-- Actions Section -->
                        @if ($user->role === 'dins')
                        <div
                            class="flex items-center justify-center md:justify-end space-x-2 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                            <button onclick="openEditModal({{ json_encode($item) }})"
                                class="p-2 rounded-full hover:bg-indigo-100 text-indigo-600 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('tabungan.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 rounded-full hover:bg-red-100 text-red-600 transition-colors">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 md:py-16">
            <div
                class="w-20 h-20 md:w-24 md:h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4 md:mb-6">
                <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg md:text-xl font-medium text-gray-900 mb-2">Belum ada data tabungan</h3>
            <p class="text-gray-500 mb-4 md:mb-6 text-sm md:text-base px-4">Mulai dengan menambah transaksi
                pertama Anda</p>
            <button
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 md:py-3 px-4 md:px-6 rounded-lg md:rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 w-full sm:w-auto"
                onclick="openModal()">
                <span class="text-sm md:text-base">Tambah Tabungan Pertama</span>
            </button>
        </div>
        @endif
    </div>
</div>