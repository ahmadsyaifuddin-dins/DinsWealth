<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tabungan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($user->role === 'dins')
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-bold mb-4">Semua Tabungan</h3>
                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                    onclick="openModal()">
                    + Tambah Tabungan
                </button>

                <ul class="space-y-2">
                    @foreach ($data as $item)
                    <li class="border-b py-2">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-bold">{{ $item->kategoriNama->nama ?? 'Tidak diketahui' }}</p>
                                <p class="text-sm text-gray-600">Jenis: 
                                    <span class="{{ $item->kategoriJenis?->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($item->kategoriJenis?->jenis ?? 'Tidak diketahui') }}
                                    </span>
                                </p>                                
                                <p class="text-sm text-gray-600">Keterangan: {{ $item->keterangan ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold {{ $item->kategoriJenis?->jenis === 'pemasukan' ? 'text-green-700' : 'text-red-700' }}">
                                    Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @elseif ($user->role === 'viewer')
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-bold mb-4">Tabungan Dins</h3>
                <ul class="space-y-2">
                    @forelse ($data as $item)
                        <li class="border-b py-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold">{{ $item->kategoriNama->nama ?? 'Tidak diketahui' }}</p>
                                    <p class="text-sm text-gray-600">Jenis: 
                                        <span class="{{ $item->kategoriJenis?->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($item->kategoriJenis?->jenis ?? 'Tidak diketahui') }}
                                        </span>
                                    </p>
                                    <p class="text-sm text-gray-600">Keterangan: {{ $item->keterangan ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold {{ $item->kategoriJenis?->jenis === 'pemasukan' ? 'text-green-700' : 'text-red-700' }}">
                                        Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                    <p>belum ada tabungan</p>
                    @endforelse
                </ul>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal() {
            document.getElementById('tabunganModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('tabunganModal').classList.add('hidden');
        }

        function formatNominal(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }
    </script>
    @endpush

    
@include('components.modal-tabungan')

</x-app-layout>