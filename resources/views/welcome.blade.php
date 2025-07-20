<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-white">
        <h1 class="text-4xl font-extrabold text-blue-600 mb-4">
            Selamat Datang di DinsFlow
        </h1>
        <p class="text-gray-600 text-lg mb-6">
            Aplikasi Pribadi dalam membantu Keuangan.
        </p>
        <a href="{{ route('login') }}"
           class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
            Login Sekarang
        </a>
    </div>
</x-guest-layout>
