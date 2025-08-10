<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-800 dark:to-emerald-800 rounded-lg p-4 md:p-6 shadow-lg dark:shadow-gray-900/50">
            <h2 class="text-xl md:text-2xl font-bold leading-tight text-white flex items-center">
                <i class="fa-solid fa-calendar-check mr-2"></i>
                Transaksi Terencana
            </h2>
            <p class="text-green-100 dark:text-green-200 mt-1 md:mt-2 text-sm md:text-base">Kelola rencana keuangan masa depan</p>
        </div>
    </x-slot>

    <div class="py-4 md:py-8 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-200">
        @include('includes.messages')
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- Tombol untuk membuka modal "Tambah Rencana" --}}
            <div class="mb-6 text-right">
                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-800 focus:outline-none focus:border-indigo-900 dark:focus:border-indigo-700 focus:ring ring-indigo-300 dark:focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Tambah Rencana
                </button>
            </div>
            
            {{-- Filter Section --}}
            <div class="mb-6">
                @include('planned-transactions.partials._filters')
            </div>

            {{-- Tabel untuk menampilkan daftar transaksi terencana --}}
            <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/50 sm:rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nominal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jatuh Tempo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse ($plannedTransactions as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100" title="{{ $item->keterangan }}">
                                                {{ \Illuminate\Support\Str::limit($item->keterangan, 50, '...') }}
                                                @if (strlen($item->keterangan) > 50)
                                                    <button onclick='openReadMoreModal(@json($item))' class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-xs underline ml-2 transition-colors">
                                                        Read More
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $item->kategoriNama?->nama ?? 'N/A' }} | 
                                                <span class="{{ $item->kategoriJenis?->jenis === 'Pemasukan' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ $item->kategoriJenis?->jenis ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            <div class="flex items-center">
                                                <i class="fa-regular fa-calendar mr-2 text-gray-400 dark:text-gray-500"></i>
                                                {{ $item->jatuh_tempo->isoFormat('D MMMM Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-700">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-700">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($item->status == 'pending')
                                                <div class="flex items-center justify-end space-x-3">
                                                    {{-- Tombol Selesaikan --}}
                                                    <button onclick='openCompleteModal(@json($item))' 
                                                            title="Selesaikan" 
                                                            class="p-2 text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-md transition-all duration-150">
                                                        <i class="fa-solid fa-check-circle fa-lg"></i>
                                                    </button>
                                                    {{-- Tombol Edit --}}
                                                    <button onclick='openEditModal(@json($item))' 
                                                            title="Edit" 
                                                            class="p-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-md transition-all duration-150">
                                                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                    </button>
                                                    {{-- Tombol Hapus --}}
                                                    <form action="{{ route('planned-transactions.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rencana ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                title="Hapus" 
                                                                class="p-2 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-all duration-150">
                                                            <i class="fa-solid fa-trash-can fa-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 italic">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 dark:text-gray-600"></i>
                                                <div class="text-gray-500 dark:text-gray-400">
                                                    <p class="text-lg font-medium">Belum ada transaksi terencana</p>
                                                    <p class="text-sm">Mulai buat rencana keuangan Anda</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Link Paginasi --}}
                    @if($plannedTransactions->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-600 pt-4">
                            <div class="pagination-wrapper">
                                {{ $plannedTransactions->links() }}
                            </div>
                        </div>
                    @endif
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
    
    @push('styles')
        <style>
            /* Custom pagination styling for dark mode */
            .pagination-wrapper .relative {
                @apply bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600;
            }
            .pagination-wrapper a, .pagination-wrapper span {
                @apply text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200;
            }
            .pagination-wrapper .bg-blue-50 {
                @apply bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300;
            }
        </style>
    @endpush
</x-app-layout>