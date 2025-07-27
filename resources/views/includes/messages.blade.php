<!-- Success Message -->
@if (session('success'))
<div class="mb-6 relative overflow-hidden">
    <div class="success-message bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-4 shadow-lg transform transition-all duration-500 hover:shadow-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-green-800 font-bold text-lg">Berhasil!</h4>
                        <p class="text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeMessage(this)" class="text-green-500 hover:text-green-700 ml-4 p-1 rounded-full hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-green-200 bg-opacity-20 rounded-full -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-300 bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
    </div>
</div>
@endif

<!-- Error Messages -->
@if ($errors->any())
<div class="mb-6 relative overflow-hidden">
    <div class="error-message bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl p-4 shadow-lg transform transition-all duration-500 hover:shadow-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center animate-bounce">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="text-red-800 font-bold text-lg">Oops! Ada kesalahan</h4>
                        <div class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                            <div class="flex items-center text-red-700">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>{{ $error }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <button onclick="closeMessage(this)" class="text-red-500 hover:text-red-700 ml-4 p-1 rounded-full hover:bg-red-100 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-red-200 bg-opacity-20 rounded-full -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-red-300 bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
    </div>
</div>
@endif

<!-- Individual Field Errors (Alternative) -->
@error('nama')
<div class="mb-4 relative overflow-hidden">
    <div class="field-error bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg p-3 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ $message }}</p>
            </div>
            <button onclick="closeMessage(this)" class="text-red-400 hover:text-red-600 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@enderror

@error('jenis')
<div class="mb-4 relative overflow-hidden">
    <div class="field-error bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg p-3 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ $message }}</p>
            </div>
            <button onclick="closeMessage(this)" class="text-red-400 hover:text-red-600 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@enderror

@error('nominal')
<div class="mb-4 relative overflow-hidden">
    <div class="field-error bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg p-3 shadow-sm">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ $message }}</p>
            </div>
            <button onclick="closeMessage(this)" class="text-red-400 hover:text-red-600 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@enderror

<!-- Info Message (Bonus) -->
@if (session('info'))
<div class="mb-6 relative overflow-hidden">
    <div class="info-message bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl p-4 shadow-lg transform transition-all duration-500 hover:shadow-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-blue-800 font-bold text-lg">Informasi</h4>
                        <p class="text-blue-700 mt-1">{{ session('info') }}</p>
                    </div>
                    <button onclick="closeMessage(this)" class="text-blue-500 hover:text-blue-700 ml-4 p-1 rounded-full hover:bg-blue-100 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-200 bg-opacity-20 rounded-full -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-blue-300 bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
    </div>
</div>
@endif

<!-- Warning Message (Bonus) -->
@if (session('warning'))
<div class="mb-6 relative overflow-hidden">
    <div class="warning-message bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-xl p-4 shadow-lg transform transition-all duration-500 hover:shadow-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4 flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-yellow-800 font-bold text-lg">Peringatan!</h4>
                        <p class="text-yellow-700 mt-1">{{ session('warning') }}</p>
                    </div>
                    <button onclick="closeMessage(this)" class="text-yellow-500 hover:text-yellow-700 ml-4 p-1 rounded-full hover:bg-yellow-100 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-200 bg-opacity-20 rounded-full -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-yellow-300 bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
    </div>
</div>
@endif

<style>
    /* Message Animations */
    .success-message, .error-message, .info-message, .warning-message, .field-error {
        animation: slideInDown 0.5s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Close Animation */
    .message-closing {
        animation: slideOutUp 0.3s ease-in forwards;
    }

    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }

    /* Auto-hide after 5 seconds */
    .success-message, .info-message {
        animation: slideInDown 0.5s ease-out, fadeOut 0.5s ease-in 4.5s forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
</style>

<script>
    // Close message function
    function closeMessage(button) {
        const messageContainer = button.closest('.mb-6, .mb-4');
        const messageElement = messageContainer.querySelector('.success-message, .error-message, .info-message, .warning-message, .field-error');
        
        messageElement.classList.add('message-closing');
        
        setTimeout(() => {
            messageContainer.remove();
        }, 300);
    }

    // Auto-hide success and info messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const autoHideMessages = document.querySelectorAll('.success-message, .info-message');
        
        autoHideMessages.forEach(message => {
            setTimeout(() => {
                if (message && message.parentElement) {
                    const button = message.querySelector('button[onclick*="closeMessage"]');
                    if (button) {
                        closeMessage(button);
                    }
                }
            }, 5000);
        });
    });

    // Add shake animation for error messages
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessages = document.querySelectorAll('.error-message, .field-error');
        
        errorMessages.forEach(message => {
            message.style.animation = 'slideInDown 0.5s ease-out, shake 0.5s ease-in-out 0.5s';
        });
    });

    // Shake animation keyframes
    const shakeStyle = document.createElement('style');
    shakeStyle.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }
    `;
    document.head.appendChild(shakeStyle);
</script>