<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DinsWealth - Kelola Keuangan Pribadi</title>
    
    <!-- Meta tags for social sharing -->
    <meta name="description" content="Aplikasi pribadi untuk mengelola keuangan, mencatat pemasukan dan pengeluaran, serta memantau tabungan dengan mudah dan aman.">
    <meta name="keywords" content="keuangan pribadi, tabungan, pencatat keuangan, manajemen uang">
    <meta name="author" content="DinsWealth">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:title" content="DinsWealth - Kelola Keuangan Pribadi">
    <meta property="og:description" content="Aplikasi pribadi untuk mengelola keuangan, mencatat pemasukan dan pengeluaran, serta memantau tabungan dengan mudah dan aman.">
    <meta property="og:image" content="{{ asset('icon_DinsWealth.png') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="">
    <meta property="twitter:title" content="DinsWealth - Kelola Keuangan Pribadi">
    <meta property="twitter:description" content="Aplikasi pribadi untuk mengelola keuangan, mencatat pemasukan dan pengeluaran, serta memantau tabungan dengan mudah dan aman.">
    <meta property="twitter:image" content="{{ asset('icon_DinsWealth.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <style>
        @keyframes gentle-float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .float-gentle { animation: gentle-float 4s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
    
    <div class="min-h-screen flex flex-col justify-center items-center px-6 py-12">
        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 max-w-md w-full text-center border border-gray-100">
            
            <!-- Logo -->
            <div class="mb-8 float-gentle">
                <img src="{{ asset('icon_DinsWealth.png') }}" alt="Logo DinsWealth" class="w-20 h-20 mx-auto">
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-800 mb-3">
                DinsWealth
            </h1>

            <!-- Subtitle -->
            <p class="text-gray-600 mb-8 leading-relaxed">
                Aplikasi pribadi untuk mengelola keuangan dan tabungan dengan mudah
            </p>

            <!-- Simple Features -->
            <div class="space-y-4 mb-8">
                <div class="flex items-center justify-start bg-gray-50 rounded-lg p-3">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-wallet text-green-600"></i>
                    </div>
                    <span class="text-gray-700 text-sm">Catat pemasukan & pengeluaran</span>
                </div>
                
                <div class="flex items-center justify-start bg-gray-50 rounded-lg p-3">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-piggy-bank text-blue-600"></i>
                    </div>
                    <span class="text-gray-700 text-sm">Monitor kas laci & tabungan</span>
                </div>
                
                <div class="flex items-center justify-start bg-gray-50 rounded-lg p-3">
                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-mobile-alt text-purple-600"></i>
                    </div>
                    <span class="text-gray-700 text-sm">Tracking saldo SeaBank</span>
                </div>
            </div>

            <!-- Login Button -->
            <a href="{{ route('login') }}" 
               class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-200 inline-flex items-center justify-center group">
                <i class="fas fa-sign-in-alt mr-2 group-hover:scale-110 transition-transform"></i>
                Masuk ke Aplikasi
            </a>

            <!-- Simple Stats -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-lg font-semibold text-gray-800">Aman</div>
                        <div class="text-xs text-gray-500">Data Terenkripsi</div>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-800">Mudah</div>
                        <div class="text-xs text-gray-500">Interface Simple</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-400 text-sm">
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

</body>
</html>