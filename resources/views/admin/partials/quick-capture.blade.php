<!-- Quick Capture AI Section -->
<div
    class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-700 mb-8 relative overflow-hidden group transition-colors duration-300">

    <!-- Hiasan Background -->
    <div
        class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-indigo-500/10 dark:bg-indigo-400/10 rounded-full blur-3xl pointer-events-none group-hover:bg-indigo-500/20 transition duration-1000">
    </div>

    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-3">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <i class="fas fa-magic text-white text-lg animate-pulse"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 leading-tight">
                    Quick Capture AI
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Catat banyak transaksi sekaligus, pakai bahasa manusia.
                </p>
            </div>
        </div>

        <form action="{{ route('quick-capture.store') }}" method="POST" class="relative mt-4"
            onsubmit="showLoading(this)">
            @csrf

            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Pilih Sumber Dana -->
                <div class="sm:w-1/3 md:w-1/4">
                    <label class="sr-only">Sumber Dana</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-wallet text-gray-400"></i>
                        </div>
                        <select name="wallet_id"
                            class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-3 pl-10 text-sm">
                            @foreach ($namaKategori as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ $kategori->nama == 'Dompet (Uang Jalan)' ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Input Text AI -->
                <div class="flex-1 relative">
                    <input type="text" name="raw_text" required autocomplete="off"
                        placeholder="Cth: Nasi padang 20rb, bensin 15k di pal 6, nemu uang 50rb"
                        class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-3 pl-4 pr-14 shadow-sm text-sm placeholder-gray-400 transition-all">

                    <!-- Submit Button -->
                    <button type="submit" id="btn-submit-ai"
                        class="absolute right-1.5 top-1.5 bottom-1.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg px-4 hover:shadow-lg hover:scale-105 active:scale-95 transition-all flex items-center justify-center">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>

            <!-- Loading Indicator (Hidden by default) -->
            <div id="loading-indicator"
                class="hidden absolute right-3 top-3.5 items-center gap-2 bg-white dark:bg-slate-800 pl-2">
                <i class="fas fa-circle-notch fa-spin text-indigo-500"></i>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Menganalisa...</span>
            </div>
        </form>

        <!-- Contoh/Tips -->
        <div class="mt-3 flex flex-wrap gap-2">
            <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Tips:</span>
            <button type="button" onclick="fillExample('Beli ayam kentucky bagian dada 9k di pal 25')"
                class="text-xs bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-md transition-colors border border-gray-200 dark:border-slate-600">
                🍽️ Makan
            </button>
            <button type="button" onclick="fillExample('Isi bensin 20rb di SPBU pal 25')"
                class="text-xs bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-md transition-colors border border-gray-200 dark:border-slate-600">
                ⛽ Transport
            </button>
            <button type="button"
                onclick="fillExample('Dikasih mama 10rb, Beli ayam kentucky bagian dada 9k di pal 25')"
                class="text-xs bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-md transition-colors border border-gray-200 dark:border-slate-600">
                💰 Pemasukan
            </button>
        </div>
    </div>
</div>

<script>
    // Fungsi Efek Loading saat Submit
    function showLoading(form) {
        const btn = document.getElementById('btn-submit-ai');
        const input = form.querySelector('input[name="raw_text"]');

        // Disable input & button
        input.readOnly = true;
        btn.disabled = true;

        // Ubah icon jadi loading
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    }

    // Fungsi klik contoh langsung isi input
    function fillExample(text) {
        const input = document.querySelector('input[name="raw_text"]');
        input.value = text;
        input.focus();
    }
</script>
