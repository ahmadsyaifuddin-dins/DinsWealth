<x-app-layout>
    <x-slot name="header">
        @include('admin.partials.dashboard-header')
    </x-slot>

    <div class="py-6 px-4 sm:py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:space-y-8">
            
            {{-- Greeting Section --}}
            @include('admin.partials.greeting-section')

            {{-- Stats Cards --}}
            @include('admin.partials.stats-cards')

            {{-- Backup Section --}}
            @include('admin.partials.backup-section')

            {{-- Chart and Activity Section --}}
            @include('admin.partials.chart-activity-section')
        </div>
    </div>
    
    {{-- Include Modal Tambah Transaksi --}}
    @include('tabungan.partials.modal-tabungan')
    
    {{-- Scripts --}}
    @include('admin.partials.dashboard-scripts')
</x-app-layout>