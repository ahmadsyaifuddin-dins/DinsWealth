<!-- GLOBAL FLASH MESSAGES CONTAINER -->
<div class="space-y-4 mb-6">

    <!-- 1. SUCCESS MESSAGE -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="relative overflow-hidden rounded-2xl shadow-lg group">

            <!-- Background & Border -->
            <div
                class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 border-l-4 border-emerald-500 dark:border-emerald-400 backdrop-blur-sm">
            </div>

            <div class="relative p-4 flex items-start">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-emerald-100 dark:bg-emerald-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-bold text-emerald-800 dark:text-emerald-300">Berhasil!</h3>
                    <p class="text-sm text-emerald-700 dark:text-emerald-200 mt-1">{{ session('success') }}</p>
                </div>
                <button @click="show = false"
                    class="ml-4 text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Progress Bar Animation (Visual Timer) -->
            <div class="absolute bottom-0 left-0 h-1 bg-emerald-500/30 w-full">
                <div class="h-full bg-emerald-500 animate-progress origin-left"></div>
            </div>
        </div>
    @endif

    <!-- 2. ERROR MESSAGE (Global) -->
    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            class="relative overflow-hidden rounded-2xl shadow-lg bg-white dark:bg-gray-800 border border-red-100 dark:border-red-900/50">

            <div
                class="absolute inset-0 bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-l-4 border-red-500 dark:border-red-500 backdrop-blur-sm">
            </div>

            <div class="relative p-4 flex items-start">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center animate-bounce-slow">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-bold text-red-800 dark:text-red-300">Oops! Ada kesalahan</h3>
                    <ul class="mt-2 text-sm text-red-700 dark:text-red-200 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false"
                    class="ml-4 text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- 3. WARNING / INFO MESSAGE -->
    @if (session('warning') || session('info'))
        @php
            $type = session('warning') ? 'warning' : 'info';
            $colors =
                $type == 'warning'
                    ? 'from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border-amber-500 text-amber-800 dark:text-amber-300'
                    : 'from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-blue-500 text-blue-800 dark:text-blue-300';
            $icon = $type == 'warning' ? 'fa-bell' : 'fa-info';
            $iconColor =
                $type == 'warning'
                    ? 'text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-500/20'
                    : 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-500/20';
            $message = session('warning') ?? session('info');
            $title = $type == 'warning' ? 'Perhatian' : 'Informasi';
        @endphp

        <div x-data="{ show: true }" x-show="show" class="relative overflow-hidden rounded-2xl shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r {{ $colors }} border-l-4 backdrop-blur-sm"></div>
            <div class="relative p-4 flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 {{ $iconColor }} rounded-full flex items-center justify-center">
                        <i class="fas {{ $icon }} text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-bold {{ explode(' ', $colors)[4] }}">{{ $title }}</h3>
                    <p class="text-sm mt-1 opacity-90 text-gray-700 dark:text-gray-200">{{ $message }}</p>
                </div>
                <button @click="show = false" class="ml-4 opacity-50 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" class="relative overflow-hidden rounded-2xl shadow-lg">
            <!-- Background Merah Gelap -->
            <div
                class="absolute inset-0 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 dark:border-red-500 backdrop-blur-sm">
            </div>

            <div class="relative p-4 flex items-start">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-red-100 dark:bg-red-500/20 rounded-full flex items-center justify-center animate-bounce-slow">
                        <i class="fas fa-times-circle text-red-600 dark:text-red-400 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-bold text-red-800 dark:text-red-300">Gagal Memproses</h3>
                    <p class="text-sm mt-1 opacity-90 text-red-700 dark:text-red-200">{{ session('error') }}</p>
                </div>
                <button @click="show = false"
                    class="ml-4 text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
</div>

<!-- CSS Animation for Progress Bar -->
<style>
    @keyframes progress {
        from {
            transform: scaleX(1);
        }

        to {
            transform: scaleX(0);
        }
    }

    .animate-progress {
        animation: progress 5s linear forwards;
    }

    .animate-bounce-slow {
        animation: bounce 2s infinite;
    }
</style>
