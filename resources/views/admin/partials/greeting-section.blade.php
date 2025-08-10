<!-- Enhanced Greeting Section -->
<div class="relative bg-gradient-to-br {{ $greeting['color'] }} rounded-3xl shadow-2xl overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-white rounded-full animate-pulse"></div>
        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-white rounded-full animate-pulse animation-delay-1000"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white rounded-full animate-pulse animation-delay-2000"></div>
    </div>
    
    <!-- Main Content -->
    <div class="relative z-10 p-6 sm:p-8">
        <!-- Header Row -->
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-6">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 mr-4 shadow-lg">
                    <i class="fas {{ $greeting['icon_waktu'] }} text-3xl text-white"></i>
                </div>
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white mb-1">
                        {{ $greeting['salam'] }}! 
                    </h3>
                    <p class="text-white/80 text-sm font-medium">{{ $greeting['tanggal'] }}</p>
                </div>
            </div>
            
            <!-- Status Icon -->
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 shadow-lg self-center sm:self-start">
                <i class="fas {{ $greeting['icon'] }} text-2xl text-white"></i>
            </div>
        </div>
        
        <!-- Main Message -->
        <div class="bg-white/15 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white/20 shadow-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-lightbulb text-2xl text-yellow-400 dark:text-yellow-300 dark:drop-shadow-[0_0_8px_rgba(255,255,150,0.9)]"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-bold text-lg mb-2">Financial Insight</h4>
                    <p class="text-white/95 text-base leading-relaxed font-medium">
                        {{ $greeting['pesan'] }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        @include('admin.partials.greeting-stats')
        
        <!-- Status Badge -->
        <div class="flex justify-center">
            <div class="inline-flex items-center text-white {{ $greeting['badge_color'] }} px-6 py-3 rounded-full text-sm font-bold border backdrop-blur-sm">
                <span class="mr-2 text-lg"><i class="fas {{ $greeting['icon_badge_color'] }} {{ $greeting['badge_icon'] }}"></i></span>
                {{ $greeting['badge_text'] }}
            </div>
        </div>
    </div>
</div>