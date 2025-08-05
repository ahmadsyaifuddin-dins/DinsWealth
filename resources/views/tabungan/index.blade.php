<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-4 md:p-6 shadow-lg">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                <div>
                    <h2 class="font-bold text-xl md:text-2xl text-white leading-tight flex items-center">
                        <i class="fa-solid fa-sack-dollar mr-2"></i>
                        {{ __('Tabungan') }}
                    </h2>
                    <p class="text-blue-100 mt-1 md:mt-2 text-sm md:text-base">Kelola keuangan dengan mudah</p>
                </div>
                
                {{-- Tambahkan tombol Sampah untuk role dins --}}
                @if($user->role === 'dins')
                <div class="flex space-x-2">
                    <a href="{{ route('tabungan.trash') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="hidden sm:inline">Sampah</span>
                    </a>
                </div>
                @endif
            </div>
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
            {{-- KARTU TOTAL SALDO (BAGIAN BARU) --}}
            {{-- =============================================== --}}
            @if(count($data) > 0 && ($user->role === 'dins' || $user->role === 'viewer'))
                @include('tabungan.partials._card_savings')
            @endif
            
            {{-- =============================================== --}}
            {{-- KODE FORM FILTER DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @include('tabungan.partials._filters')
            
            {{-- =============================================== --}}
            {{-- KODE TABLE Dins DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @if ($user->role === 'dins')
                @include('tabungan.partials._dins_view')

            {{-- =============================================== --}}
            {{-- TAMBAHKAN MODAL KONFIRMASI HAPUS (BARU) --}}
            {{-- =============================================== --}}    
            @if($user->role === 'dins')
                @include('tabungan.partials.modal-delete-confirm')
            @endif

            {{-- =============================================== --}}
            {{-- KODE TABLE VIEWER DIMULAI DARI SINI --}}
            {{-- =============================================== --}}
            @elseif ($user->role === 'viewer')
                @include('tabungan.partials._viewer_view')
            @endif
        </div>
    </div>

    @push('scripts')
        @include('tabungan.partials._scripts')
    @endpush
    
    {{-- Include semua modal --}}
    @include('tabungan.partials.modal-tabungan')
    @include('tabungan.partials.modal-tabungan-edit')
    
   
</x-app-layout>