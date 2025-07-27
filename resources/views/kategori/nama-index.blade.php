<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Kategori Nama Tabungan</h2>
    </x-slot>

    <div class="p-6 max-w-2xl mx-auto">

        @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('kategori.nama.store') }}" class="mb-6 flex items-center gap-2">
            @csrf
            <input type="text" name="nama" placeholder="Nama kategori"
                class="border p-2 rounded w-full @error('nama') border-red-500 @enderror" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
        </form>

        @error('nama')
        <div class="text-red-600 mb-4">{{ $message }}</div>
        @enderror

        <ul class="space-y-2">
            @forelse($data as $item)
            <li class="border-b pb-2 flex justify-between items-center">
                <span>{{ $item->nama }}</span>
                <div class="flex gap-2">
                    <button onclick="openModal('modalEdit{{ $item->id }}')"
                        class="text-blue-600 hover:underline">Edit</button>
                    <form method="POST" action="{{ route('kategori.nama.destroy', $item->id) }}"
                        onsubmit="return confirm('Yakin mau hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </li>

            <!-- Modal Edit -->
            <div id="modalEdit{{ $item->id }}"
                class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50">
                <div class="bg-white p-6 rounded shadow w-full max-w-md">
                    <h2 class="text-lg font-bold mb-4">Edit Kategori Nama Tabungan</h2>
                    <form method="POST" action="{{ route('kategori.nama.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nama" value="{{ $item->nama }}" required
                            class="border p-2 w-full rounded mb-4">
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('modalEdit{{ $item->id }}')"
                                class="px-3 py-1 bg-gray-300 rounded">Batal</button>
                            <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <li class="text-gray-500 italic">Belum ada kategori tabungan.</li>
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