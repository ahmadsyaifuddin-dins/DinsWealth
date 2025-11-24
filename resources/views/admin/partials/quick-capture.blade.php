<!-- Quick Capture AI Section -->
<div
    class="bg-white dark:bg-slate-800 rounded-3xl p-5 sm:p-8 shadow-xl border border-gray-100 dark:border-slate-700 mb-8 relative overflow-hidden group transition-colors duration-300">

    <!-- Hiasan Background -->
    <div
        class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-indigo-500/10 dark:bg-indigo-400/10 rounded-full blur-3xl pointer-events-none group-hover:bg-indigo-500/20 transition duration-1000">
    </div>

    <div class="relative z-10">
        <!-- Header: Icon & Title -->
        <div class="flex items-start gap-3 mb-4">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <i class="fas fa-magic text-white text-lg animate-pulse"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 leading-tight">
                    Quick Capture AI
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Catat banyak transaksi sekaligus pakai bahasa manusia.
                </p>
            </div>
        </div>

        <form action="{{ route('quick-capture.store') }}" method="POST" class="relative mt-4"
            onsubmit="showLoading(this)">
            @csrf

            <div class="flex flex-col gap-3">
                <!-- 1. Pilih Sumber Dana (Full Width di Mobile) -->
                <div class="w-full">
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

                <!-- 2. Input Area (Textarea + Tombol Kirim Terpisah) -->
                <div class="relative w-full">
                    <!-- Ganti Input jadi Textarea -->
                    <textarea name="raw_text" rows="4" required
                        placeholder="Cth: Nasi padang 20rb, bensin 15k di pal 6, nemu uang 50rb..."
                        class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 p-4 text-sm placeholder-gray-400 transition-all resize-none shadow-sm focus:shadow-md"></textarea>

                    <!-- Tombol Kirim (Floating di kanan bawah textarea) -->
                    <button type="submit" id="btn-submit-ai"
                        class="absolute right-2 bottom-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg p-2.5 shadow-lg hover:shadow-indigo-500/30 hover:scale-105 active:scale-95 transition-all flex items-center justify-center group-btn">
                        <i class="fas fa-paper-plane text-sm group-btn-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Contoh/Tips -->
        <div class="mt-4">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Contoh Cepat:</span>
            <div class="flex flex-wrap gap-2">
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
                    💰 Jajan
                </button>
                <button type="button" onclick="fillExample('Terima bayaran joki dari client 40k')"
                    class="text-xs bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 px-2 py-1 rounded-md transition-colors border border-gray-200 dark:border-slate-600">
                    💳 Pemasukan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Overlay Loading (NON-AKTIFKAN SESUAI REQUEST) -->
<!--
<div id="full-page-loading" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-2xl flex flex-col items-center transform scale-100 animate-bounce-slow max-w-[80%] text-center">
        <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin mb-4"></div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Mencatat Transaksi...</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tunggu sebentar ya beb! 😘</p>
    </div>
</div>
-->

<script>
    // Fungsi Efek Loading saat Submit
    function showLoading(form) {
        const btn = document.getElementById('btn-submit-ai');
        const input = form.querySelector('textarea[name="raw_text"]');
        // const overlay = document.getElementById('full-page-loading'); // Matikan overlay

        // Tampilkan overlay full screen (MATIKAN)
        /*
        if(overlay) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }
        */

        // Ubah tombol jadi loading (Cukup di tombol saja biar lebih smooth)
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
            input.focus(); // Fokus ke textarea agar user bisa langsung edit
            // form.requestSubmit(); // MATIKAN AUTO SUBMIT
        }
    }
</script>
