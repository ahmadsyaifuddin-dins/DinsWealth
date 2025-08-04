<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            🗓️ Transaksi Terencana
        </h2>
    </x-slot>

    <div class="py-12">
        @include('includes.messages')
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Tombol untuk membuka modal "Tambah Rencana" --}}
            <div class="mb-6 text-right">
                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    + Tambah Rencana
                </button>
            </div>

            {{-- Tabel untuk menampilkan daftar transaksi terencana --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($plannedTransactions as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900" title="{{ $item->keterangan }}">
                                                {{ \Illuminate\Support\Str::limit($item->keterangan, 50, '...') }}
                                                @if (strlen($item->keterangan) > 50)
                                                    <button onclick='openReadMoreModal(@json($item))' class="text-indigo-600 hover:text-indigo-900 text-xs underline ml-2">
                                                        Read More
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item->kategoriNama?->nama ?? 'N/A' }} | 
                                                <span class="{{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $item->kategoriJenis?->jenis ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Rp{{ number_format($item->nominal, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->jatuh_tempo->isoFormat('D MMMM Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($item->status == 'pending')
                                                <div class="flex items-center justify-end space-x-4">
                                                    {{-- Tombol Selesaikan --}}
                                                    <button onclick='openCompleteModal(@json($item))' title="Selesaikan" class="text-green-600 hover:text-green-900 transition-colors">
                                                        <i class="fa-solid fa-check-circle fa-lg"></i>
                                                    </button>
                                                    {{-- Tombol Edit --}}
                                                    <button onclick='openEditModal(@json($item))' title="Edit" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                    </button>
                                                    {{-- Tombol Hapus --}}
                                                    <form action="{{ route('planned-transactions.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rencana ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus" class="text-red-600 hover:text-red-900 transition-colors">
                                                            <i class="fa-solid fa-trash-can fa-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada transaksi terencana.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $plannedTransactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panggil semua modal dari file partial --}}
    @include('planned-transactions.partials._modals')

    @push('scripts')
        {{-- Panggil semua script dari file partial --}}
        @include('planned-transactions.partials._scripts')
    @endpush
</x-app-layout>