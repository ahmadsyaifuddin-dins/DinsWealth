<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 px-4 sm:px-0">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Sampah Tabungan') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('tabungan.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 touch-manipulation">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                @if($trashedTabungans->count() > 0)
                    <button onclick="openRestoreAllModal()" class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 touch-manipulation">
                        <i class="fa-solid fa-rotate mr-2"></i>
                        Pulihkan Semua
                    </button>
                    <button onclick="openEmptyTrashModal()" class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 touch-manipulation">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Kosongkan Sampah
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm sm:text-base" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm sm:text-base" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    @if($trashedTabungans->count() > 0)
                        <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative text-sm sm:text-base" role="alert">
                            <span class="block sm:inline">
                                <strong>Info:</strong> Terdapat {{ $trashedTabungans->total() }} data tabungan dalam sampah.
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-[640px] w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[5%]">No</th>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[20%]">Nama Tabungan</th>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[15%]">Jenis</th>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[15%]">Nominal</th>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[20%]">Keterangan</th>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[15%]">Dihapus Pada</th>
                                        <th class="px-2 sm:px-3 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[25%]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($trashedTabungans as $key => $tabungan)
                                        <tr class="bg-red-50">
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                                {{ $trashedTabungans->firstItem() + $key }}
                                            </td>
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 text-xs sm:text-sm text-gray-900">
                                                {{ $tabungan->kategoriNama->nama ?? 'N/A' }}
                                            </td>
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $tabungan->jenis == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $tabungan->kategoriJenis->jenis ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                                {{ $tabungan->formatted_nominal }}
                                            </td>
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 text-xs sm:text-sm text-gray-900">
                                                {{ Str::limit($tabungan->keterangan, 30) }}
                                            </td>
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                                {{ $tabungan->deleted_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-2 sm:px-3 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium space-x-1 sm:space-x-2">
                                                <button onclick="restoreData({{ $tabungan->id }})" class="text-green-600 hover:text-green-900 inline-flex items-center touch-manipulation">
                                                    <i class="fa-solid fa-rotate mr-1"></i>
                                                    <span class="hidden sm:inline">Pulihkan</span>
                                                    <span class="sm:hidden">Restore</span>
                                                </button>
                                                <button onclick="openForceDeleteModal({{ $tabungan->id }}, '{{ $tabungan->kategoriNama->nama ?? 'N/A' }}')" class="text-red-600 hover:text-red-900 inline-flex items-center touch-manipulation">
                                                    <i class="fa-solid fa-trash mr-1"></i>
                                                    <span class="hidden sm:inline">Hapus Permanen</span>
                                                    <span class="sm:hidden">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4 px-4 sm:px-0">
                            {{ $trashedTabungans->links() }}
                        </div>
                    @else
                        <div class="text-center py-8 sm:py-12">
                            <i class="fa-solid fa-trash"></i>
                            <h3 class="mt-2 text-sm sm:text-base font-medium text-gray-900">Sampah kosong</h3>
                            <p class="mt-1 text-sm text-gray-500">Tidak ada data tabungan yang dihapus.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Permanen -->
    <div id="forceDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-4 sm:p-5 border w-11/12 sm:w-96 max-w-full shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fa-solid fa-trash text-red-600"></i>
                </div>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mt-2">Konfirmasi Hapus Permanen</h3>
                <div class="mt-2 px-4 sm:px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Anda akan menghapus permanen data tabungan: <strong id="forceDeleteTabunganName"></strong>
                    </p>
                    <p class="text-sm text-red-600 font-medium mt-3">
                        ⚠️ PERINGATAN: Data akan dihapus permanen dari database dan tidak dapat dipulihkan!
                    </p>
                    <p class="text-sm text-red-600 font-medium mt-2">
                        Ketik "HAPUS PERMANEN" untuk melanjutkan:
                    </p>
                    <input type="text" id="forceDeleteConfirmationInput" class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="Ketik HAPUS PERMANEN">
                    <p id="forceDeleteConfirmationError" class="text-red-500 text-xs mt-1 hidden">Anda harus mengetik "HAPUS PERMANEN" dengan benar!</p>
                </div>
                <div class="items-center px-4 py-3 space-y-3">
                    <button id="confirmForceDeleteBtn" class="px-4 py-2 bg-red-600 text-white text-sm sm:text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 touch-manipulation">
                        Hapus Permanen
                    </button>
                    <button onclick="closeForceDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm sm:text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 touch-manipulation">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Pulihkan Semua -->
    <div id="restoreAllModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-4 sm:p-5 border w-11/12 sm:w-96 max-w-full shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <i class="fa-solid fa-rotate text-green-600"></i>
                </div>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mt-2">Konfirmasi Pulihkan Semua</h3>
                <div class="mt-2 px-4 sm:px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Anda akan memulihkan semua data tabungan yang ada di sampah.
                    </p>
                    <p class="text-sm text-green-600 font-medium mt-2">
                        Ketik "PULIHKAN SEMUA" untuk melanjutkan:
                    </p>
                    <input type="text" id="restoreAllConfirmationInput" class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Ketik PULIHKAN SEMUA">
                    <p id="restoreAllConfirmationError" class="text-red-500 text-xs mt-1 hidden">Anda harus mengetik "PULIHKAN SEMUA" dengan benar!</p>
                </div>
                <div class="items-center px-4 py-3 space-y-3">
                    <button id="confirmRestoreAllBtn" class="px-4 py-2 bg-green-600 text-white text-sm sm:text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 touch-manipulation">
                        Pulihkan Semua
                    </button>
                    <button onclick="closeRestoreAllModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm sm:text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 touch-manipulation">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Kosongkan Sampah -->
    <div id="emptyTrashModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-4 sm:p-5 border w-11/12 sm:w-96 max-w-full shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fa-solid fa-trash text-red-600"></i>
                </div>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mt-2">Konfirmasi Kosongkan Sampah</h3>
                <div class="mt-2 px-4 sm:px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Anda akan menghapus permanen SEMUA data tabungan yang ada di sampah.
                    </p>
                    <p class="text-sm text-red-600 font-medium mt-3">
                        ⚠️ PERINGATAN: Semua data akan dihapus permanen dari database dan tidak dapat dipulihkan!
                    </p>
                    <p class="text-sm text-red-600 font-medium mt-2">
                        Ketik "KOSONGKAN SAMPAH" untuk melanjutkan:
                    </p>
                    <input type="text" id="emptyTrashConfirmationInput" class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="Ketik KOSONGKAN SAMPAH">
                    <p id="emptyTrashConfirmationError" class="text-red-500 text-xs mt-1 hidden">Anda harus mengetik "KOSONGKAN SAMPAH" dengan benar!</p>
                </div>
                <div class="items-center px-4 py-3 space-y-3">
                    <button id="confirmEmptyTrashBtn" class="px-4 py-2 bg-red-600 text-white text-sm sm:text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 touch-manipulation">
                        Kosongkan Sampah
                    </button>
                    <button onclick="closeEmptyTrashModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm sm:text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 touch-manipulation">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTabunganId = null;

        // Pulihkan data individual
        function restoreData(tabunganId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/tabungan/restore/${tabunganId}`;
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = '{{ csrf_token() }}';
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        }

        // Modal Hapus Permanen
        function openForceDeleteModal(tabunganId, tabunganName) {
            currentTabunganId = tabunganId;
            document.getElementById('forceDeleteTabunganName').textContent = tabunganName;
            document.getElementById('forceDeleteConfirmationInput').value = '';
            document.getElementById('forceDeleteConfirmationError').classList.add('hidden');
            document.getElementById('forceDeleteModal').classList.remove('hidden');
        }

        function closeForceDeleteModal() {
            currentTabunganId = null;
            document.getElementById('forceDeleteModal').classList.add('hidden');
        }

        document.getElementById('confirmForceDeleteBtn').addEventListener('click', function() {
            const confirmationText = document.getElementById('forceDeleteConfirmationInput').value;
            const errorElement = document.getElementById('forceDeleteConfirmationError');

            if (confirmationText !== 'HAPUS PERMANEN') {
                errorElement.classList.remove('hidden');
                return;
            }

            if (currentTabunganId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tabungan/force-delete/${currentTabunganId}`;
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                const tokenField = document.createElement('input');
                tokenField.type = 'hidden';
                tokenField.name = '_token';
                tokenField.value = '{{ csrf_token() }}';
                
                form.appendChild(methodField);
                form.appendChild(tokenField);
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Modal Pulihkan Semua
        function openRestoreAllModal() {
            document.getElementById('restoreAllConfirmationInput').value = '';
            document.getElementById('restoreAllConfirmationError').classList.add('hidden');
            document.getElementById('restoreAllModal').classList.remove('hidden');
        }

        function closeRestoreAllModal() {
            document.getElementById('restoreAllModal').classList.add('hidden');
        }

        document.getElementById('confirmRestoreAllBtn').addEventListener('click', function() {
            const confirmationText = document.getElementById('restoreAllConfirmationInput').value;
            const errorElement = document.getElementById('restoreAllConfirmationError');

            if (confirmationText !== 'PULIHKAN SEMUA') {
                errorElement.classList.remove('hidden');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/tabungan/restore-all';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = '{{ csrf_token() }}';
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        });

        // Modal Kosongkan Sampah
        function openEmptyTrashModal() {
            document.getElementById('emptyTrashConfirmationInput').value = '';
            document.getElementById('emptyTrashConfirmationError').classList.add('hidden');
            document.getElementById('emptyTrashModal').classList.remove('hidden');
        }

        function closeEmptyTrashModal() {
            document.getElementById('emptyTrashModal').classList.add('hidden');
        }

        document.getElementById('confirmEmptyTrashBtn').addEventListener('click', function() {
            const confirmationText = document.getElementById('emptyTrashConfirmationInput').value;
            const errorElement = document.getElementById('emptyTrashConfirmationError');

            if (confirmationText !== 'KOSONGKAN SAMPAH') {
                errorElement.classList.remove('hidden');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/tabungan/empty-trash';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = '{{ csrf_token() }}';
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        });

        // Close modals when clicking outside
        document.getElementById('forceDeleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeForceDeleteModal();
            }
        });

        document.getElementById('restoreAllModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRestoreAllModal();
            }
        });

        document.getElementById('emptyTrashModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEmptyTrashModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeForceDeleteModal();
                closeRestoreAllModal();
                closeEmptyTrashModal();
            }
        });
    </script>
</x-app-layout>