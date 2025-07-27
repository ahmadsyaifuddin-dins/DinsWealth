<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-4 md:p-6 shadow-lg">
            <h2 class="font-bold text-xl md:text-2xl text-white leading-tight flex items-center">
                <svg class="w-6 h-6 md:w-8 md:h-8 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                {{ __('Tabungan') }}
            </h2>
            <p class="text-blue-100 mt-1 md:mt-2 text-sm md:text-base">Kelola keuangan Anda dengan mudah</p>
        </div>
    </x-slot>

    <div class="py-4 md:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- =============================================== --}}
            {{-- AREA GRAFIK (BAGIAN BARU) --}}
            {{-- =============================================== --}}
            @if(count($data) > 0 && $user->role === 'dins')
            @include('tabungan.partials._charts')
            @endif
            {{-- =============================================== --}}

            {{-- =============================================== --}}
            {{-- KODE FORM FILTER DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @include('tabungan.partials._filters')
            {{-- =============================================== --}}
            {{-- KODE FORM FILTER SELESAI --}}
            {{-- =============================================== --}}

            @include('includes.messages')

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