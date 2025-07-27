<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tabungan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($user->role === 'dins')
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-bold mb-4">Semua Tabungan</h3>
                    <ul class="space-y-2">
                        @foreach ($data as $item)
                            <li class="border-b py-2">
                                {{ $item->user->name }}: <strong>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @elseif ($user->role === 'viewer')
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-bold mb-4">Tabungan Kamu</h3>
                    <ul class="space-y-2">
                        @forelse ($data as $item)
                            <li class="border-b py-2">
                                Jumlah: <strong>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</strong>
                            </li>
                        @empty
                            <p>belum ada tabungan</p>
                        @endforelse
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
