<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold leading-tight text-gray-900">
            Halo, {{ Auth::user()->name }}! 👋
        </h2>
        <p class="text-sm text-gray-600 mt-1">
            {{ $greeting['salam'] }}, semoga harimu menyenangkan!
        </p>
    </div>
    <div class="mt-3 sm:mt-0 text-right">
        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Dashboard Keuangan</p>
        <p class="text-sm text-gray-700 font-medium">{{ $greeting['tanggal'] }}</p>
    </div>
</div>