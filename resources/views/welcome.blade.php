<x-app-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-6 py-12">
        <!-- Main Card -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8 md:p-12 max-w-md w-full text-center border border-gray-100 dark:border-slate-700 transition-colors duration-300">
            
            <!-- Logo -->
            <div class="mb-8 float-gentle">
                <img src="{{ asset('icon_DinsWealth.png') }}" 
                     alt="Logo DinsWealth" 
                     class="w-20 h-20 mx-auto transition-all duration-300 dark:drop-shadow-[0_0_15px_rgba(59,130,246,0.8)]">
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-3">
                DinsWealth
            </h1>

            <!-- Subtitle -->
            <p class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                Aplikasi pribadi untuk mengelola keuangan dan tabungan dengan mudah
            </p>

            <!-- Simple Features -->
            <div class="space-y-4 mb-8">
                <div class="flex items-center justify-start bg-gray-50 dark:bg-slate-700 rounded-lg p-3 transition-colors duration-300">
                    <div class="bg-green-100 dark:bg-green-900/40 p-2 rounded-lg mr-3">
                        <i class="fas fa-wallet text-green-600 dark:text-green-400"></i>
                    </div>
                    <span class="text-gray-700 dark:text-gray-200 text-sm">Catat pemasukan & pengeluaran</span>
                </div>
                
                <div class="flex items-center justify-start bg-gray-50 dark:bg-slate-700 rounded-lg p-3 transition-colors duration-300">
                    <div class="bg-blue-100 dark:bg-blue-900/40 p-2 rounded-lg mr-3">
                        <i class="fas fa-piggy-bank text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <span class="text-gray-700 dark:text-gray-200 text-sm">Monitor kas laci & tabungan</span>
                </div>
                
                <div class="flex items-center justify-start bg-gray-50 dark:bg-slate-700 rounded-lg p-3 transition-colors duration-300">
                    <div class="bg-purple-100 dark:bg-purple-900/40 p-2 rounded-lg mr-3">
                        <i class="fas fa-mobile-alt text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <span class="text-gray-700 dark:text-gray-200 text-sm">Tracking saldo SeaBank</span>
                </div>
            </div>

            <!-- Login Button -->
            <a href="{{ route('login') }}" 
               class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-200 inline-flex items-center justify-center group">
                <i class="fas fa-sign-in-alt mr-2 group-hover:scale-110 transition-transform"></i>
                Masuk ke Aplikasi
            </a>

            <!-- Simple Stats -->
            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">Aman</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Data Terenkripsi</div>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">Mudah</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Interface Simple</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-400 dark:text-gray-500 text-sm">
            <div class="flex items-center justify-center space-x-4">
                <span class="flex items-center">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Pribadi & Aman
                </span>
                <span>•</span>
                <span class="flex items-center">
                    <i class="fas fa-heart mr-1"></i>
                    Made for Personal Use
                </span>
            </div>
        </div>
    </div>
</x-app-layout>
