<div
    class="flex flex-col items-center justify-center py-10 px-4 text-center border-2 border-dashed border-gray-100 dark:border-slate-700 rounded-3xl m-2">
    <!-- Illustration Icon -->
    <div
        class="bg-gray-50 dark:bg-slate-800 w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center mb-4 animate-bounce-slow">
        <i class="fas fa-receipt text-gray-300 dark:text-slate-600 text-2xl sm:text-3xl"></i>
    </div>

    <!-- Text -->
    <h4 class="text-gray-800 dark:text-gray-200 font-bold text-base sm:text-lg mb-1">
        Belum Ada Transaksi
    </h4>
    <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mb-6 max-w-[200px] sm:max-w-xs mx-auto">
        Data aktivitas keuanganmu akan muncul di sini setelah kamu mencatat transaksi.
    </p>

    <!-- Action Button -->
    <button onclick="openModal()"
        class="group relative inline-flex items-center justify-center px-6 py-2.5 sm:py-3 text-sm font-semibold text-white transition-all duration-200 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full hover:from-blue-700 hover:to-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 dark:focus:ring-offset-gray-900">
        <i class="fas fa-plus mr-2 text-xs transition-transform group-hover:rotate-90"></i>
        Tambah Transaksi
    </button>
</div>
