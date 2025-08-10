<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-gray-100">
            Halo, {{ Auth::user()->name }}! <i class="fa-solid fa-face-smile text-green-600 dark:text-yellow-400"></i>
        </h2>
        <p class="text-sm text-gray-600 mt-1 dark:text-gray-300">
            {{ $greeting['salam'] }}, semoga harimu menyenangkan!
        </p>
    </div>
    <div class="mt-3 sm:mt-0 text-right">
        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold dark:text-gray-300">Dashboard Keuangan</p>
        <p class="text-sm text-gray-700 font-medium dark:text-gray-300">{{ $greeting['tanggal'] }}</p>
    </div>
</div>