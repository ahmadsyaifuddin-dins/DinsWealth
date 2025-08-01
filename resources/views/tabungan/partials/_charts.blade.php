<div class="mb-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">📊 Ringkasan Visual</h3>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h4 class="text-lg font-semibold text-gray-700 mb-2 text-center">Pemasukan vs Pengeluaran</h4>
            <canvas id="pieChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h4 class="text-lg font-semibold text-gray-700 mb-2 text-center">Top 5 Kategori Pengeluaran</h4>
            <canvas id="barChart"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-lg font-semibold text-gray-700">Riwayat Arus Kas</h4>
                <div class="flex space-x-1 bg-gray-200 p-1 rounded-lg">
                    <button id="lineChartHourlyBtn" class="px-3 py-1 text-sm font-semibold rounded-md text-gray-600">Per Jam</button>
                    <button id="lineChartDailyBtn" class="px-3 py-1 text-sm font-semibold rounded-md bg-white text-indigo-600 shadow">Harian</button>
                    <button id="lineChartMonthlyBtn" class="px-3 py-1 text-sm font-semibold rounded-md text-gray-600">Bulanan</button>
                </div>
            </div>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>