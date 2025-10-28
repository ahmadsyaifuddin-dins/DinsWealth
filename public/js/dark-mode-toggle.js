// public/js/dark-mode-toggle.js

class DarkModeToggle {
    constructor() {
        this.darkModeToggle = document.getElementById('darkModeToggle'); // Old button fallback
        this.themeToggle = document.getElementById('themeToggle'); // New toggle component
        this.html = document.documentElement;
        this.init();
    }

    init() {
        // MODIFIKASI:
        // Skrip inline di <head> sudah mengatur tema.
        // Kita sekarang HANYA perlu membaca state yang ada untuk mengatur tombolnya.
        const currentTheme = this.html.classList.contains('dark') ? 'dark' : 'light';
        this.updateAllToggles(currentTheme);
        
        // Add event listeners
        if (this.darkModeToggle) {
            this.darkModeToggle.addEventListener('click', () => this.toggleTheme());
        }

        if (this.themeToggle) {
            this.themeToggle.addEventListener('change', (e) => {
                // Gunakan setManualTheme untuk menyimpan preferensi
                this.setManualTheme(e.target.checked ? 'dark' : 'light');
            });
        }

        // Listen for external theme changes
        window.addEventListener('themeChanged', (e) => {
            this.updateAllToggles(e.detail.theme);
        });

        // Tetap jalankan watchSystemTheme untuk mendeteksi perubahan OS
        this.watchSystemTheme();
    }

    /**
     * Helper function untuk MENGAPLIKASIKAN class & dispatch event.
     * TIDAK MENYIMPAN ke localStorage.
     */
    setTheme(theme) {
        const isDark = theme === 'dark';
        
        if (isDark) {
            this.html.classList.add('dark');
        } else {
            this.html.classList.remove('dark');
        }
        
        this.updateAllToggles(theme);
        
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { 
                theme: theme,
                timestamp: Date.now()
            }
        }));

        // Transisi tetap di sini
        this.html.style.transition = 'background-color 0.3s ease, color 0.3s ease';
        setTimeout(() => {
            this.html.style.transition = '';
        }, 300);
    }

    updateAllToggles(theme) {
        const isDark = theme === 'dark';
        
        if (this.themeToggle) {
            this.themeToggle.checked = isDark;
        }
        
        const allToggles = document.querySelectorAll('[data-theme-toggle]');
        allToggles.forEach(toggle => {
            if (toggle.type === 'checkbox') {
                toggle.checked = isDark;
            }
        });
    }

    toggleTheme() {
        const isDark = this.html.classList.contains('dark');
        // Selalu gunakan setManualTheme saat user berinteraksi
        this.setManualTheme(isDark ? 'light' : 'dark');
    }

    getCurrentTheme() {
        return this.html.classList.contains('dark') ? 'dark' : 'light';
    }

    watchSystemTheme() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            // MODIFIKASI: Hapus setter awal. Skrip inline sudah menanganinya.
            
            // HANYA dengarkan perubahan
            mediaQuery.addEventListener('change', (e) => {
                // HANYA auto-switch jika user ada di mode "System"
                // (yaitu tidak ada 'theme' di localStorage)
                if (!localStorage.getItem('theme')) {
                    this.setTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }

    /**
     * Fungsi utama saat USER memilih tema.
     * Ini MENYIMPAN ke localStorage.
     */
    setManualTheme(theme) {
        // 1. Simpan pilihan user
        localStorage.setItem('theme', theme);
        localStorage.setItem('lastThemeChange', Date.now().toString()); // Sesuai logikamu
        
        // 2. Terapkan tema
        this.setTheme(theme);
    }

    resetToSystemTheme() {
        // 1. Hapus preferensi user
        localStorage.removeItem('theme');
        localStorage.removeItem('lastThemeChange');
        
        // 2. Deteksi & terapkan tema sistem
        if (window.matchMedia) {
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            this.setTheme(systemPrefersDark ? 'dark' : 'light');
        } else {
            this.setTheme('light'); // Fallback
        }
    }

    getSystemTheme() {
        if (window.matchMedia) {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        return 'light';
    }
}

// Inisialisasi tidak berubah
document.addEventListener('DOMContentLoaded', function() {
    if (!window.darkModeToggle) {
        window.darkModeToggle = new DarkModeToggle();
    }
});

if (document.readyState === 'loading') {
    // DOM masih loading
} else {
    // DOM sudah loaded
    if (!window.darkModeToggle) {
        window.darkModeToggle = new DarkModeToggle();
    }
}

if (typeof module !== 'undefined' && module.exports) {
    module.exports = DarkModeToggle;
}

// Global functions (pastikan mereka memanggil setManualTheme)
window.toggleTheme = function() {
    if (window.darkModeToggle) {
        window.darkModeToggle.toggleTheme(); // Ini sudah benar
    }
};

window.setTheme = function(theme) {
    if (window.darkModeToggle) {
        window.darkModeToggle.setManualTheme(theme); // Pastikan panggil manual
    }
};