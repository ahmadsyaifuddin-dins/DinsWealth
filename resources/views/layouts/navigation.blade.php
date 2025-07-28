@php
$user = Auth::user();
@endphp

<nav x-data="{ open: false, masterDropdownOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(Auth::user()->role === 'dins')
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-nav-link>
                    @if(Auth::user()->role === 'dins')
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                                <div>Master Kategori</div>
                                <div class="ml-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('kategori.nama.index')">
                                Kategori Nama Tabungan
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('kategori.jenis.index')">
                                Kategori Jenis Tabungan
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif
                    <x-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.*')">
                        {{ __('Tabungan') }}
                    </x-nav-link>
                    @elseif(Auth::user()->role === 'viewer')
                    <x-nav-link :href="route('viewer.dashboard')" :active="request()->routeIs('viewer.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.index')">
                        {{ __('Tabungan') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 transition">
                            <div>{{ $user->name }}</div>
                            <div class="ml-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'dins')
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard Admin') }}
            </x-responsive-nav-link>

            <!-- Master Kategori Dropdown for Mobile -->
            <div class="px-4 pt-2">
                <button @click="masterDropdownOpen = !masterDropdownOpen" 
                        class="flex items-center justify-between w-full text-left px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                    <span>Master Kategori</span>
                    <svg class="ml-2 h-5 w-5 transform transition-transform duration-200" 
                         :class="{ 'rotate-180': masterDropdownOpen }" 
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="masterDropdownOpen" x-transition:enter="transition ease-out duration-100" 
                     x-transition:enter-start="transform opacity-0 scale-95" 
                     x-transition:enter-end="transform opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-75" 
                     x-transition:leave-start="transform opacity-100 scale-100" 
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="mt-2 pl-4 space-y-1 border-l-2 border-gray-200">
                    <x-responsive-nav-link :href="route('kategori.nama.index')" :active="request()->routeIs('kategori.nama.*')" class="pl-4">
                        {{ __('Kategori Nama Tabungan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kategori.jenis.index')" :active="request()->routeIs('kategori.jenis.*')" class="pl-4">
                        {{ __('Kategori Jenis Tabungan') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.*')">
                {{ __('Tabungan') }}
            </x-responsive-nav-link>
            
            @elseif(Auth::user()->role === 'viewer')
            <x-responsive-nav-link :href="route('viewer.dashboard')" :active="request()->routeIs('viewer.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.index')">
                {{ __('Tabungan') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ $user->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $user->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>