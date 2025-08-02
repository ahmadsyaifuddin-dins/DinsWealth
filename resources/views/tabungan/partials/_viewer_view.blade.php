<div class="bg-white rounded-xl md:rounded-2xl shadow-xl overflow-hidden">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 md:p-6">
        <div class="flex items-center">
            <div
                class="w-12 h-12 md:w-16 md:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-xl md:text-2xl text-white mb-1">👁️ Tabungan Dins</h3>
                <p class="text-emerald-100 text-sm md:text-base">Mode view only - Lihat data keuangan</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 md:p-8">
        @forelse ($data as $item)
        <div
            class="group bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-lg md:rounded-xl p-4 md:p-6 hover:shadow-lg transition-all duration-300 hover:border-emerald-200 mb-3 md:mb-4">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start space-y-4 md:space-y-0">
                <div class="flex-1">
                    <div class="flex items-start md:items-center mb-3">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 rounded-full {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                            @if ($item->kategoriJenis?->jenis === 'Pemasukan')
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
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
                                <div class="flex items-center text-xs text-gray-500 space-x-2">
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
            </div>
        </div>
        @empty
        <div class="text-center py-12 md:py-16">
            <div
                class="w-20 h-20 md:w-24 md:h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4 md:mb-6">
                <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg md:text-xl font-medium text-gray-900 mb-2">Belum ada tabungan</h3>
            <p class="text-gray-500 text-sm md:text-base px-4">Data tabungan akan muncul di sini ketika
                tersedia</p>
        </div>
        @endforelse
    </div>
</div>