{{-- Modal Konfirmasi Hapus --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-xl bg-white dark:bg-slate-900">
        <div class="mt-3 text-center">
            {{-- Icon Warning --}}
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            {{-- Title --}}
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-300 mb-4">
                <i class="fa-solid fa-warning mr-2 text-red-500"></i>
                Konfirmasi Penghapusan</h3>
            
            {{-- Content --}}
            <div class="px-2 py-3">
                <div class="bg-red-50 dark:bg-slate-700 border border-red-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                        Anda akan menghapus data tabungan:
                    </p>
                    <p class="font-bold text-gray-900 dark:text-gray-300 text-lg" id="tabunganName"></p>
                    <p class="font-semibold text-red-700 dark:text-red-400 text-lg" id="tabunganAmount"></p>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-yellow-800">
                        <i class="fa-solid fa-info-circle mr-1"></i>
                        <strong>Info:</strong> Data akan dipindahkan ke sampah dan dapat dipulihkan nanti.
                    </p>
                </div>
                
                <div class="text-left">
                    <label class="block text-sm font-bold text-red-600 mb-2">
                        Ketik "KONFIRMASI" untuk melanjutkan:
                    </label>
                    <input type="text" id="confirmationInput" 
                           class="w-full dark:bg-slate-700 dark:text-gray-300 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-center font-bold text-lg" 
                           placeholder="Ketik KONFIRMASI"
                           autocomplete="off">
                    <p id="confirmationError" class="text-red-500 text-sm mt-2 hidden font-medium">
                        <i class="fa-solid fa-exclamation-triangle mr-1"></i>
                        Anda harus mengetik "KONFIRMASI" dengan benar!
                    </p>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="px-4 py-3 space-y-3">
                <button id="confirmDeleteBtn" 
                        class="w-full px-6 py-3 bg-red-600 text-white text-base font-bold rounded-lg shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200">
                    <i class="fa-solid fa-trash mr-2"></i>
                    Hapus Data
                </button>
                <button onclick="closeDeleteModal()" 
                        class="w-full px-6 py-3 bg-gray-200 dark:bg-slate-700 dark:text-gray-300 text-gray-700 text-base font-bold rounded-lg shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200">
                    <i class="fa-solid fa-times mr-2"></i>
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript untuk Modal --}}
<script>
    let currentTabunganId = null;
    let currentTabunganData = null;

    function openDeleteModal(tabunganId, tabunganData) {
        currentTabunganId = tabunganId;
        currentTabunganData = tabunganData;
        
        // Set nama tabungan
        document.getElementById('tabunganName').textContent = tabunganData.kategori_nama || 'Tidak diketahui';
        
        // Set nominal dengan format dan warna
        const amountElement = document.getElementById('tabunganAmount');
        const isIncome = tabunganData.kategori_jenis === 'Pemasukan';
        const sign = isIncome ? '+' : '-';
        const colorClass = isIncome ? 'text-green-600' : 'text-red-600';
        
        amountElement.textContent = `${sign}Rp${new Intl.NumberFormat('id-ID').format(tabunganData.nominal)}`;
        amountElement.className = `font-semibold text-lg ${colorClass}`;
        
        // Reset form
        document.getElementById('confirmationInput').value = '';
        document.getElementById('confirmationError').classList.add('hidden');
        
        // Show modal
        document.getElementById('deleteModal').classList.remove('hidden');
        
        // Focus on input
        setTimeout(() => {
            document.getElementById('confirmationInput').focus();
        }, 100);
    }

    function closeDeleteModal() {
        currentTabunganId = null;
        currentTabunganData = null;
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Handle confirm delete button
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        const confirmationText = document.getElementById('confirmationInput').value.trim();
        const errorElement = document.getElementById('confirmationError');

        if (confirmationText !== 'KONFIRMASI') {
            errorElement.classList.remove('hidden');
            // Shake animation
            const input = document.getElementById('confirmationInput');
            input.classList.add('animate-pulse');
            setTimeout(() => input.classList.remove('animate-pulse'), 500);
            return;
        }

        if (currentTabunganId) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/tabungan/${currentTabunganId}`;
            
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

    // Handle Enter key in input
    document.getElementById('confirmationInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('confirmDeleteBtn').click();
        }
    });

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>