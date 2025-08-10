<div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
    
    <!-- Chart Header with Enhanced Controls -->
    @include('admin.partials.chart-header')
    
    <!-- Chart Container with Enhanced Design -->
    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-inner">
        <canvas id="expenseChart" height="300" class="rounded-xl"></canvas>
        
        <!-- Chart Overlay Info -->
        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg">
            <p class="text-xs text-gray-600 font-medium" id="chartInfo">Loading...</p>
        </div>
    </div>
    
    <!-- Enhanced Chart Stats -->
    @include('admin.partials.chart-stats')
</div>