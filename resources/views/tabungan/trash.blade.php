<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <i class="fa-solid fa-trash-arrow-up"></i> Sampah Tabungan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dihapus</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($trashedTabungan as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->keterangan }}</div>
                                            <div class="text-xs text-gray-500">Rp{{ number_format($item->nominal, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->deleted_at->isoFormat('D MMMM Y, HH:mm') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-4">
                                                {{-- Tombol Pulihkan --}}
                                                <form action="{{ route('tabungan.restore', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Pulihkan</button>
                                                </form>
                                                {{-- Tombol Hapus Permanen --}}
                                                <form action="{{ route('tabungan.forceDelete', $item->id) }}" method="POST" onsubmit="return confirm('ANDA YAKIN? Data ini akan dihapus permanen dan tidak bisa dikembalikan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus Permanen</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data di dalam sampah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $trashedTabungan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>