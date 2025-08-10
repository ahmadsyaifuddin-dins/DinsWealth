<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold flex items-center gap-2 text-black dark:text-white">
            <i class="fa-solid fa-layer-group text-blue-600"></i>
            Kategori Nama Tabungan
        </h2>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">

        @if (session('success'))
        <div
            class="mb-4 p-3 bg-green-100 text-green-800 rounded flex items-center gap-2 dark:bg-green-900 dark:text-green-200">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('kategori.nama.store') }}"
            class="mb-6 flex items-center gap-2 bg-white dark:bg-gray-800 p-4 rounded shadow">
            @csrf
            <input type="text" name="nama" placeholder="Nama kategori"
                class="border p-2 dark:bg-slate-700 dark:text-white rounded w-full @error('nama') border-red-500 @enderror"
                required>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded flex items-center gap-1 hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus"></i> Tambah
            </button>
        </form>

        @error('nama')
        <div class="text-red-600 mb-4 flex items-center gap-2 dark:text-red-400">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
        </div>
        @enderror

        <ul class="space-y-2">
            @forelse($data as $item)
            <li class="border-b pb-2 flex justify-between items-center">
                <span class="flex items-center gap-2 text-black dark:text-white">
                    {{ $item->nama }}
                </span>
                <div class="flex gap-2">
                    <button onclick="openModal('modalEdit{{ $item->id }}')"
                        class="text-blue-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <form method="POST" action="{{ route('kategori.nama.destroy', $item->id) }}"
                        onsubmit="return confirm('Yakin mau hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline flex items-center gap-1 dark:text-red-400">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </li>

            <!-- Modal Edit -->
            <div id="modalEdit{{ $item->id }}"
                class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50">
                <div class="bg-white p-6 rounded shadow w-full max-w-md dark:bg-slate-900">
                    <h2
                        class="text-lg font-bold mb-4 flex items-center gap-2 bg-white text-black dark:bg-slate-900 dark:text-white">
                        <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                        Edit Kategori Nama Tabungan
                    </h2>
                    <form method="POST" action="{{ route('kategori.nama.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nama" value="{{ $item->nama }}" required
                            class="border p-2 w-full rounded mb-4 dark:bg-slate-700 dark:text-white">
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                                class="px-3 py-1 bg-gray-300 rounded flex items-center gap-1">
                                <i class="fa-solid fa-xmark"></i> Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-1 bg-blue-600 text-white rounded flex items-center gap-1">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <li class="text-gray-500 dark:text-gray-400 italic flex items-center gap-2">
                <i class="fa-solid fa-layer-group"></i> Belum ada kategori tabungan.
            </li>
            @endforelse
        </ul>
    </div>

    @push('scripts')
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }
    
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>
    @endpush
</x-app-layout>