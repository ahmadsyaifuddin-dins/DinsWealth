<div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-8 border border-gray-100 dark:border-slate-700">
    
    <!-- Chart Header with Enhanced Controls -->
    @include('admin.partials.chart-header')
    
    <!-- Chart Container with Enhanced Design -->
    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-inner dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-800">
        <canvas id="expenseChart" height="300" class="rounded-xl"></canvas>
        
        <!-- Chart Overlay Info -->
        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg dark:bg-white/90 dark:backdrop-blur-sm dark:shadow-lg">
            <p class="text-xs text-gray-600 font-medium" id="chartInfo">Loading...</p>
        </div>
    </div>
    
    <!-- Enhanced Chart Stats -->
    @include('admin.partials.chart-stats')
</div>