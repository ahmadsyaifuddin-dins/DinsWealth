<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-4 md:p-6 shadow-lg">
            <h2 class="font-bold text-xl md:text-2xl text-white leading-tight flex items-center">
                <i class="fa-solid fa-sack-dollar mr-2"></i>
                {{ __('Tabungan') }}
            </h2>
            <p class="text-blue-100 mt-1 md:mt-2 text-sm md:text-base">Kelola keuangan dengan mudah</p>
        </div>
    </x-slot>

    <div class="py-4 md:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @include('includes.messages')
            {{-- =============================================== --}}
            {{-- AREA GRAFIK (BAGIAN BARU) --}}
            {{-- =============================================== --}}
            @if(count($data) > 0 && ($user->role === 'dins' || $user->role === 'viewer'))
            @include('tabungan.partials._charts')
            @endif
            {{-- =============================================== --}}

            {{-- =============================================== --}}
            {{-- KARTU TOTAL SALDO (BAGIAN BARU) --}}
            {{-- =============================================== --}}
            @if(count($data) > 0 && ($user->role === 'dins' || $user->role === 'viewer'))
            @include('tabungan.partials._card_savings')
            @endif
            {{-- =============================================== --}}

            {{-- =============================================== --}}
            {{-- KODE FORM FILTER DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @include('tabungan.partials._filters')
            {{-- =============================================== --}}
            {{-- KODE FORM FILTER SELESAI --}}
            {{-- =============================================== --}}


            {{-- =============================================== --}}
            {{-- KODE TABLE Dins DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @if ($user->role === 'dins')
            @include('tabungan.partials._dins_view')
            {{-- =============================================== --}}
            {{-- KODE TABLE Dins SELESAI --}}
            {{-- =============================================== --}}

            {{-- =============================================== --}}
            {{-- KODE TABLE VIEWER DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @elseif ($user->role === 'viewer')
            @include('tabungan.partials._viewer_view')
            {{-- =============================================== --}}
            {{-- KODE TABLE VIEWER SELESAI --}}
            {{-- =============================================== --}}
            @endif
        </div>
    </div>

    @push('scripts')
    @include('tabungan.partials._scripts')
    @endpush

    @include('components.modal-tabungan')
    @include('components.modal-tabungan-edit')
</x-app-layout>