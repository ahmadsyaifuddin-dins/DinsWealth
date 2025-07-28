<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DinsWealth - Kelola Keuangan Pribadi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite alternate',
                        'slide-up': 'slide-up 0.8s ease-out forwards',
                        'fade-in': 'fade-in 1s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        'pulse-glow': {
                            '0%': { boxShadow: '0 0 20px rgba(59, 130, 246, 0.3)' },
                            '100%': { boxShadow: '0 0 30px rgba(59, 130, 246, 0.6)' }
                        },
                        'slide-up': {
                            '0%': { transform: 'translateY(50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        'fade-in': {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-purple-400 to-pink-600 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-40 left-40 w-60 h-60 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full mix-blend-multiply filter blur-xl opacity-15 animate-float" style="animation-delay: 4s;"></div>
    </div>

    <!-- Floating money icons -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-20 text-green-400 opacity-20 animate-float">
            <i class="fas fa-coins text-2xl"></i>
        </div>
        <div class="absolute top-32 right-32 text-blue-400 opacity-20 animate-float" style="animation-delay: 1s;">
            <i class="fas fa-wallet text-xl"></i>
        </div>
        <div class="absolute bottom-32 left-32 text-purple-400 opacity-20 animate-float" style="animation-delay: 3s;">
            <i class="fas fa-piggy-bank text-2xl"></i>
        </div>
        <div class="absolute bottom-40 right-20 text-indigo-400 opacity-20 animate-float" style="animation-delay: 2s;">
            <i class="fas fa-chart-line text-xl"></i>
        </div>
        <div class="absolute top-1/2 left-10 text-cyan-400 opacity-20 animate-float" style="animation-delay: 4s;">
            <i class="fas fa-dollar-sign text-lg"></i>
        </div>
        <div class="absolute top-1/3 right-10 text-emerald-400 opacity-20 animate-float" style="animation-delay: 5s;">
            <i class="fas fa-credit-card text-lg"></i>
        </div>
    </div>

    <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-8">
        <!-- Main content container -->
        <div class="text-center max-w-4xl mx-auto animate-slide-up">
            <!-- Logo/Icon -->
            <div class="flex items-center justify-center">
                <img src="{{ asset('icon_DinsWealth.png') }}" alt="Logo DinsWealth" class="w-28 h-28">
            </div>

            <!-- Main title -->
            <h1 class="text-6xl md:text-7xl font-black bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6 animate-fade-in" style="animation-delay: 0.4s;">
                DinsWealth
            </h1>

            <!-- Subtitle -->
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-4 animate-fade-in" style="animation-delay: 0.6s;">
                Kelola Keuangan Pribadi dengan Mudah
            </h2>

            <!-- Description -->
            <p class="text-gray-600 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed animate-fade-in" style="animation-delay: 0.8s;">
                Aplikasi pintar untuk mengelola uang masuk dan keluar, memantau tabungan kas laci, dan tracking saldo SeaBank Anda. 
                Semua dalam satu tempat yang aman dan mudah digunakan.
            </p>

            <!-- Features grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-12 animate-fade-in" style="animation-delay: 1s;">
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-green-400 to-emerald-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Uang Masuk & Keluar</h3>
                    <p class="text-gray-600 text-sm">Catat semua transaksi harian dengan mudah dan rapi</p>
                </div>
                
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-piggy-bank text-white text-xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Kas Laci</h3>
                    <p class="text-gray-600 text-sm">Pantau uang tunai yang tersimpan di kas laci Anda</p>
                </div>
                
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-white text-xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">SeaBank Digital</h3>
                    <p class="text-gray-600 text-sm">Tracking saldo elektronik SeaBank secara otomatis</p>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="animate-fade-in" style="animation-delay: 1.2s;">
                <a href="{{ route('login') }}" 
                   class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold text-lg rounded-full shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 hover:from-blue-600 hover:to-indigo-700">
                    <i class="fas fa-sign-in-alt mr-3 group-hover:animate-pulse"></i>
                    Login Sekarang
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 animate-fade-in" style="animation-delay: 1.4s;">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-1 counter" data-target="100">0</div>
                    <div class="text-gray-500 text-sm">Pengguna Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 mb-1 counter" data-target="1000">0</div>
                    <div class="text-gray-500 text-sm">Transaksi</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-1 counter" data-target="50">0</div>
                    <div class="text-gray-500 text-sm">Fitur Lengkap</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-1">99%</div>
                    <div class="text-gray-500 text-sm">Kepuasan</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-gray-400 text-sm animate-fade-in" style="animation-delay: 1.6s;">
            <div class="flex items-center space-x-2">
                <i class="fas fa-shield-alt"></i>
                <span>Aman & Terpercaya</span>
                <span class="mx-2">•</span>
                <i class="fas fa-lock"></i>
                <span>Data Terenkripsi</span>
            </div>
        </div>
    </div>

    <script>
        // Login handler (replace with your actual route)
        // function loginHandler() {
        //     // For Laravel: window.location.href = "{{ route('login') }}";
        //     alert('Redirect ke halaman login');
        // }

        // Counter animation
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.counter');
            
            const animateCounter = (counter) => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 100;
                let current = 0;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
            };

            // Intersection Observer for counter animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            });

            counters.forEach(counter => observer.observe(counter));

            // Add some interactive particles
            createParticles();
        });

        // Particle system
        function createParticles() {
            const particlesContainer = document.createElement('div');
            particlesContainer.className = 'fixed inset-0 pointer-events-none z-0';
            document.body.appendChild(particlesContainer);

            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'absolute w-1 h-1 bg-blue-400 opacity-30 rounded-full';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animation = 'float 6s ease-in-out infinite';
                particlesContainer.appendChild(particle);
            }
        }

        // Mouse follow effect
        document.addEventListener('mousemove', (e) => {
            const cursor = document.createElement('div');
            cursor.className = 'fixed w-2 h-2 bg-blue-400 rounded-full pointer-events-none z-50 opacity-50';
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            cursor.style.transform = 'translate(-50%, -50%)';
            cursor.style.animation = 'fade-in 0.1s ease-out forwards, fade-out 0.5s ease-out 0.1s forwards';
            
            document.body.appendChild(cursor);
            
            setTimeout(() => {
                cursor.remove();
            }, 600);
        });

        // Add fade-out animation to CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fade-out {
                to { opacity: 0; transform: translate(-50%, -50%) scale(2); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>