@php
$user = Auth::user();
@endphp

<nav x-data="{ open: false, masterDropdownOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-colors duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-100" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(Auth::user()->role === 'dins')
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-b-2 border-transparent' }}">
                        {{ __('Dashboard Admin') }}
                    </x-nav-link>
                    @if(Auth::user()->role === 'dins')
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
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
                    <x-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.*')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('tabungan.*') ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-b-2 border-transparent' }}">
                        {{ __('Tabungan') }}
                    </x-nav-link>
                    @elseif(Auth::user()->role === 'viewer')
                    <x-nav-link :href="route('viewer.dashboard')" :active="request()->routeIs('viewer.dashboard')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('viewer.dashboard') ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-b-2 border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.index')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('tabungan.index') ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-b-2 border-transparent' }}">
                        {{ __('Tabungan') }}
                    </x-nav-link>
                    @endif
                    @if(Auth::user()->role === 'dins')
                    <x-nav-link :href="route('planned-transactions.index')" :active="request()->routeIs('planned-transactions.*')" class="text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white {{ request()->routeIs('planned-transactions.*') ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'border-b-2 border-transparent' }}">
                        {{ __('Transaksi Terencana') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right Side Items -->
            <div class="flex items-center space-x-3">
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggle" 
                        class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200" 
                        title="Toggle Dark Mode">
                    <i class="fa-solid fa-moon dark:hidden text-lg"></i>
                    <i class="fa-solid fa-sun hidden dark:inline text-lg"></i>
                </button>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100 transition-colors">
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
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
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
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-800">
            @if(Auth::user()->role === 'dins')
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-l-4 border-blue-500' : '' }}">
                {{ __('Dashboard Admin') }}
            </x-responsive-nav-link>

            <!-- Master Kategori Dropdown for Mobile -->
            <div class="px-4 pt-2 bg-white dark:bg-gray-800">
                <button @click="masterDropdownOpen = !masterDropdownOpen" 
                        class="flex items-center justify-between w-full text-left px-3 py-2 text-base font-medium text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <span>Master Kategori</span>
                    <svg class="ml-2 h-5 w-5 transform transition-transform duration-200 text-gray-600 dark:text-gray-300" 
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
                     class="mt-2 pl-4 space-y-1 border-l-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800">
                    <x-responsive-nav-link :href="route('kategori.nama.index')" :active="request()->routeIs('kategori.nama.*')" class="pl-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('kategori.nama.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : '' }}">
                        {{ __('Kategori Nama Tabungan') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kategori.jenis.index')" :active="request()->routeIs('kategori.jenis.*')" class="pl-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('kategori.jenis.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : '' }}">
                        {{ __('Kategori Jenis Tabungan') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.*')" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('tabungan.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-l-4 border-blue-500' : '' }}">
                {{ __('Tabungan') }}
            </x-responsive-nav-link>
            @if(Auth::user()->role === 'dins')
            <x-responsive-nav-link :href="route('planned-transactions.index')" :active="request()->routeIs('planned-transactions.*')" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('planned-transactions.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-l-4 border-blue-500' : '' }}">
                {{ __('Transaksi Terencana') }}
            </x-responsive-nav-link>
            @endif
            
            @elseif(Auth::user()->role === 'viewer')
            <x-responsive-nav-link :href="route('viewer.dashboard')" :active="request()->routeIs('viewer.dashboard')" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('viewer.dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-l-4 border-blue-500' : '' }}">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tabungan.index')" :active="request()->routeIs('tabungan.index')" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('tabungan.index') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-l-4 border-blue-500' : '' }}">
                {{ __('Tabungan') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800">
            <div class="px-4 bg-white dark:bg-gray-800">
                <div class="font-medium text-base text-gray-800 dark:text-gray-100">{{ $user->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-300">{{ $user->email }}</div>
            </div>

            <div class="mt-3 space-y-1 bg-white dark:bg-gray-800">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 {{ request()->routeIs('profile.edit') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border-l-4 border-blue-500' : '' }}">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>