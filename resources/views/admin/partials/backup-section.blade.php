<!-- Enhanced Backup Section -->
<div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <!-- Left Side - Info -->
        <div class="mb-6 lg:mb-0 lg:flex-1">
            <div class="flex items-center mb-4">
                <!-- <div class="bg-gradient-to-br from-blue-500 to-cyan-600 w-12 h-12 rounded-2xl flex items-center justify-center mr-4">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div> -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Data Backup & Export</h3>
                    <p class="text-gray-600">Lindungi data keuanganmu dengan backup berkala</p>
                </div>
            </div>
            
            @include('admin.partials.backup-info')
        </div>
        
        <!-- Right Side - Form -->
        <div class="lg:flex-shrink-0 lg:ml-8">
            @include('admin.partials.backup-form')
        </div>
    </div>
</div>