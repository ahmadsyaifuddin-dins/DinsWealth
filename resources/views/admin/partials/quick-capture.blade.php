<!-- Quick Capture AI Section -->
<div
    class="bg-white dark:bg-slate-800 rounded-3xl p-5 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-700 mb-8 relative overflow-hidden group transition-colors duration-300">

    <!-- Hiasan Background -->
    <div
        class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-indigo-500/10 dark:bg-indigo-400/10 rounded-full blur-3xl pointer-events-none group-hover:bg-indigo-500/20 transition duration-1000">
    </div>

    <div class="relative z-10">
        <!-- 1. HEADER: Flex-start & Spacing -->
        <div class="flex items-start gap-4 mb-5">
            <div
                class="flex-shrink-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <i class="fas fa-magic text-white text-xl animate-pulse"></i>
            </div>
            <div class="pt-1">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 leading-tight">
                    Quick Capture AI
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Catat banyak transaksi sekaligus pakai bahasa manusia.
                </p>
            </div>
        </div>

        <form action="{{ route('quick-capture.store') }}" method="POST" class="relative mt-2"
            onsubmit="showLoading(this)">
            @csrf

            <div class="flex flex-col gap-4">
                <!-- Pilih Sumber Dana -->
                <div class="w-full">
                    <label class="sr-only">Sumber Dana</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-wallet text-gray-400"></i>
                        </div>
                        <select name="wallet_id"
                            class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-3 pl-10 text-sm appearance-none">
                            @foreach ($namaKategori as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ $kategori->nama == 'Dompet (Uang Jalan)' ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Custom Arrow Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- 2. TEXTAREA FIX: Space Lebih Luas -->
                <div class="relative w-full">
                    <!--
                        PERBAIKAN UTAMA DI SINI:
                        Ubah 'pr-14' menjadi 'pr-20' atau 'pr-24' agar teks tidak menabrak tombol.
                        Saya set ke 'pr-24' (sekitar 6rem) agar aman banget.
                    -->
                    <textarea name="raw_text" rows="3" required
                        placeholder="Cth: Nasi padang 20rb, bensin 15k di pal 6, nemu uang 50rb..."
                        class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 p-4 pr-24 text-sm placeholder-gray-400 transition-all resize-none shadow-sm focus:shadow-md leading-relaxed"></textarea>

                    <!-- Tombol Kirim -->
                    <button type="submit" id="btn-submit-ai"
                        class="absolute right-3 bottom-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg w-10 h-10 shadow-lg hover:shadow-indigo-500/30 hover:scale-105 active:scale-95 transition-all flex items-center justify-center group-btn z-10">
                        <i class="fas fa-paper-plane text-sm group-btn-hover:translate-x-0.5 transition-transform"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Contoh/Tips -->
        <div class="mt-4">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Starter Pack:</span>
            <div class="flex flex-wrap gap-2">

                <!-- 1. MAKAN (Dengan Lokasi) -->
                <button type="button" onclick="fillExample('Beli Ayam Kentucky bagian dada 9k di Pal 25')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-orange-50 dark:hover:bg-orange-900/20 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-utensils text-orange-500 group-hover:scale-110 transition-transform"></i>
                    <span>Makan</span>
                </button>

                <!-- 2. TRANSPORT (Simpel) -->
                <button type="button" onclick="fillExample('Isi bensin Pertamax 20rb di SPBU pal 25')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-gas-pump text-blue-500 group-hover:scale-110 transition-transform"></i>
                    <span>Bensin</span>
                </button>

                <!-- 3. BELANJA (Dengan Qty/Pcs - Menguji Parser Baru) -->
                <button type="button" onclick="fillExample('Indomaret: Beli Roti 10k dan Mie 2pcs 5k, Minuman 4rb')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-pink-50 dark:hover:bg-pink-900/20 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-cart-shopping text-pink-500 group-hover:scale-110 transition-transform"></i>
                    <span>Belanja</span>
                </button>

                <!-- 4. SHOPEE (Warna Khas Shopee) -->
                <button type="button" onclick="fillExample('Shopee: Beli Baju 50rb')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-orange-100 dark:hover:bg-orange-900/30 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-bag-shopping text-orange-600 group-hover:scale-110 transition-transform"></i>
                    <span>Shopee 1</span>
                </button>

                <!-- 4.1 SHOPEE (Warna Khas Shopee) -->
                <button type="button" onclick="fillExample('Shopee: Beli Cemilan Roti total 50k')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-orange-100 dark:hover:bg-orange-900/30 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-bag-shopping text-orange-600 group-hover:scale-110 transition-transform"></i>
                    <span>Shopee 2</span>
                </button>

                <!-- 5. TAGIHAN/DIGITAL -->
                <button type="button" onclick="fillExample('Beli Paket Data Telkomsel 25rb')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-wifi text-indigo-500 group-hover:scale-110 transition-transform"></i>
                    <span>Pulsa/Data</span>
                </button>

                <!-- 6. PEMASUKAN (Joki/Gaji) -->
                <button type="button" onclick="fillExample('Terima bayaran Joki Makalah dari Client 50k')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i
                        class="fa-solid fa-money-bill-trend-up text-emerald-500 group-hover:scale-110 transition-transform"></i>
                    <span>Pemasukan</span>
                </button>

                <!-- 7. KOMBO (Dikasih + Jajan) -->
                <button type="button"
                    onclick="fillExample('Dikasih mama 10rb, Beli ayam kentucky bagian dada 9k di pal 25')"
                    class="text-xs bg-gray-50 dark:bg-slate-700/50 hover:bg-purple-50 dark:hover:bg-purple-900/20 text-gray-600 dark:text-gray-300 px-3 py-2 rounded-lg transition-colors border border-gray-200 dark:border-slate-600 group flex items-center gap-2">
                    <i class="fa-solid fa-shuffle text-purple-500 group-hover:scale-110 transition-transform"></i>
                    <span>Mix</span>
                </button>

            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi Efek Loading saat Submit
    function showLoading(form) {
        const btn = document.getElementById('btn-submit-ai');
        const input = form.querySelector('textarea[name="raw_text"]');

        if (btn) {
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }

        if (input) {
            input.readOnly = true;
        }
    }

    // Fungsi klik contoh langsung isi input (TANPA AUTO SUBMIT)
    function fillExample(text) {
        const input = document.querySelector('textarea[name="raw_text"]');

        if (input) {
            input.value = text;
            input.focus(); // Fokus agar user bisa edit
        }
    }
</script>
