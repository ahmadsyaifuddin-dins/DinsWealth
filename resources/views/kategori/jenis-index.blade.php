<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold flex items-center gap-2 text-black dark:text-white">
            <i class="fa-solid fa-layer-group text-blue-500"></i>
            Kategori Jenis Tabungan
        </h2>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Tambah --}}
        <form method="POST" action="{{ route('kategori.jenis.store') }}" 
              class="mb-6 flex items-center gap-2 bg-white dark:bg-gray-800 p-4 rounded shadow">
            @csrf
            <input type="text" name="jenis" placeholder="Jenis tabungan"
                class="border p-2 rounded w-full dark:bg-gray-700 dark:text-white dark:border-gray-600 
                       focus:border-blue-500 focus:ring focus:ring-blue-300 @error('jenis') border-red-500 @enderror"
                required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah
            </button>
        </form>

        {{-- Error --}}
        @error('jenis')
            <div class="text-red-600 dark:text-red-400 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </div>
        @enderror

        {{-- List Kategori --}}
        <ul class="space-y-2">
            @forelse($data as $item)
                <li class="border-b pb-2 flex justify-between items-center dark:border-gray-700">
                    <span class="dark:text-gray-200">{{ $item->jenis }}</span>
                    <div class="flex gap-2">
                        <button onclick="openModal('modalEdit{{ $item->id }}')"
                            class="text-blue-600 hover:underline dark:text-blue-400 flex items-center gap-1">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <form method="POST" action="{{ route('kategori.jenis.destroy', $item->id) }}"
                            onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline dark:text-red-400 flex items-center gap-1">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </li>

                {{-- Modal Edit --}}
                <div id="modalEdit{{ $item->id }}"
                    class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50 p-4">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow w-full max-w-md transition-all">
                        <h2 class="text-lg font-bold mb-4 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Kategori Jenis Tabungan
                        </h2>
                        <form method="POST" action="{{ route('kategori.jenis.update', $item->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="text" name="jenis" value="{{ $item->jenis }}" required
                                class="border p-2 w-full rounded mb-4 dark:bg-gray-700 dark:text-white dark:border-gray-600 
                                       focus:border-blue-500 focus:ring focus:ring-blue-300">
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                                    class="px-3 py-1 bg-gray-300 dark:bg-gray-600 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-500">
                                    Batal
                                </button>
                                <button type="submit" class="px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <li class="text-gray-500 italic dark:text-gray-400">Belum ada kategori jenis tabungan.</li>
            @endforelse
        </ul>
    </div>
    
    @push('scripts')
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    
        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
    @endpush
</x-app-layout>
