<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 shadow-lg">
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ __('Tabungan') }}
            </h2>
            <p class="text-blue-100 mt-2">Kelola keuangan Anda dengan mudah</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.messages')
            @if ($user->role === 'dins')
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-2xl text-white mb-2">💰 Semua Tabungan</h3>
                            <p class="text-indigo-100">Pantau semua transaksi keuangan Anda</p>
                        </div>
                        <button class="bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-3 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center"
                            onclick="openModal()">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Tabungan
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    @if(count($data) > 0)
                    <div class="grid gap-4">
                        @foreach ($data as $item)
                        <div class="group bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:border-indigo-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 rounded-full {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center mr-4">
                                            @if($item->kategoriJenis?->jenis === 'Pemasukan')
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg text-gray-800">{{ $item->kategoriNama->nama ?? 'Tidak diketahui' }}</h4>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($item->kategoriJenis?->jenis ?? 'Tidak diketahui') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($item->keterangan && $item->keterangan !== '-')
                                    <div class="bg-gray-50 rounded-lg p-3 mt-3">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Keterangan:</span> {{ $item->keterangan }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                <div class="text-right ml-6">
                                    <p class="text-2xl font-bold {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? '+' : '-' }}Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                    </p>
                                    <div class="w-16 h-1 {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-400' : 'bg-red-400' }} rounded-full mt-2 ml-auto"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada data tabungan</h3>
                        <p class="text-gray-500 mb-6">Mulai dengan menambah transaksi pertama Anda</p>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200"
                            onclick="openModal()">
                            Tambah Tabungan Pertama
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            @elseif ($user->role === 'viewer')
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-2xl text-white mb-1">👁️ Tabungan Dins</h3>
                            <p class="text-emerald-100">Mode view only - Lihat data keuangan</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    @forelse ($data as $item)
                    <div class="group bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:border-emerald-200 mb-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 rounded-full {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center mr-4">
                                        @if($item->kategoriJenis?->jenis === 'Pemasukan')
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-800">{{ $item->kategoriNama->nama ?? 'Tidak diketahui' }}</h4>
                                        <div class="flex items-center mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($item->kategoriJenis?->jenis ?? 'Tidak diketahui') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if($item->keterangan && $item->keterangan !== '-')
                                <div class="bg-gray-50 rounded-lg p-3 mt-3">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Keterangan:</span> {{ $item->keterangan }}
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="text-right ml-6">
                                <p class="text-2xl font-bold {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? '+' : '-' }}Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                </p>
                                <div class="w-16 h-1 {{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'bg-green-400' : 'bg-red-400' }} rounded-full mt-2 ml-auto"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada tabungan</h3>
                        <p class="text-gray-500">Data tabungan akan muncul di sini ketika tersedia</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal() {
            document.getElementById('tabunganModal').classList.remove('hidden');
            // Add smooth entrance animation
            setTimeout(() => {
                document.getElementById('tabunganModal').querySelector('.modal-content').classList.add('animate-pulse');
            }, 100);
        }

        function closeModal() {
            document.getElementById('tabunganModal').classList.add('hidden');
        }

        function formatNominal(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }

        // Add some smooth animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.group');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
    @endpush

    @include('components.modal-tabungan')
</x-app-layout>