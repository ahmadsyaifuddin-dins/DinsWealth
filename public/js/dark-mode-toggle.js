// public/js/dark-mode-toggle.js

class DarkModeToggle {
    constructor() {
        this.darkModeToggle = document.getElementById('darkModeToggle'); // Old button fallback
        this.themeToggle = document.getElementById('themeToggle'); // New toggle component
        this.html = document.documentElement;
        this.init();
    }

    init() {
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        this.setTheme(currentTheme);
        
        // Add event listeners for both old and new toggles
        if (this.darkModeToggle) {
            this.darkModeToggle.addEventListener('click', () => this.toggleTheme());
        }

        if (this.themeToggle) {
            this.themeToggle.addEventListener('change', (e) => {
                this.setTheme(e.target.checked ? 'dark' : 'light');
            });
        }

        // Listen for external theme changes
        window.addEventListener('themeChanged', (e) => {
            this.updateAllToggles(e.detail.theme);
        });

        // System preference detection
        this.watchSystemTheme();
    }

    setTheme(theme) {
        const isDark = theme === 'dark';
        
        if (isDark) {
            this.html.classList.add('dark');
        } else {
            this.html.classList.remove('dark');
        }
        
        // Update all toggle states
        this.updateAllToggles(theme);
        
        localStorage.setItem('theme', theme);
        
        // Dispatch custom event for other components to listen
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { 
                theme: theme,
                timestamp: Date.now()
            }
        }));

        // Add smooth transition class temporarily
        this.html.style.transition = 'background-color 0.3s ease, color 0.3s ease';
        setTimeout(() => {
            this.html.style.transition = '';
        }, 300);
    }

    updateAllToggles(theme) {
        const isDark = theme === 'dark';
        
        // Update new toggle component
        if (this.themeToggle) {
            this.themeToggle.checked = isDark;
        }
        
        // Update any other toggle elements that might exist
        const allToggles = document.querySelectorAll('[data-theme-toggle]');
        allToggles.forEach(toggle => {
            if (toggle.type === 'checkbox') {
                toggle.checked = isDark;
            }
        });
    }

    toggleTheme() {
        const isDark = this.html.classList.contains('dark');
        this.setTheme(isDark ? 'light' : 'dark');
    }

    getCurrentTheme() {
        return this.html.classList.contains('dark') ? 'dark' : 'light';
    }

    // Watch for system theme changes
    watchSystemTheme() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            // Only apply system theme if no user preference is saved
            if (!localStorage.getItem('theme')) {
                this.setTheme(mediaQuery.matches ? 'dark' : 'light');
            }

            // Listen for system theme changes
            mediaQuery.addEventListener('change', (e) => {
                // Only auto-switch if user hasn't manually set a preference recently
                const lastManualChange = localStorage.getItem('lastThemeChange');
                const now = Date.now();
                
                if (!lastManualChange || (now - parseInt(lastManualChange)) > 300000) { // 5 minutes
                    this.setTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }

    // Method to manually override system theme
    setManualTheme(theme) {
        localStorage.setItem('lastThemeChange', Date.now().toString());
        this.setTheme(theme);
    }

    // Method to reset to system preference
    resetToSystemTheme() {
        localStorage.removeItem('theme');
        localStorage.removeItem('lastThemeChange');
        
        if (window.matchMedia) {
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            this.setTheme(systemPrefersDark ? 'dark' : 'light');
        } else {
            this.setTheme('light');
        }
    }

    // Utility method to get system preference
    getSystemTheme() {
        if (window.matchMedia) {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        return 'light';
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Prevent multiple instances
    if (!window.darkModeToggle) {
        window.darkModeToggle = new DarkModeToggle();
    }
});

// Initialize immediately if DOM is already loaded
if (document.readyState === 'loading') {
    // DOM is still loading
} else {
    // DOM is already loaded
    if (!window.darkModeToggle) {
        window.darkModeToggle = new DarkModeToggle();
    }
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DarkModeToggle;
}

// Global utility functions
window.toggleTheme = function() {
    if (window.darkModeToggle) {
        window.darkModeToggle.toggleTheme();
    }
};

window.setTheme = function(theme) {
    if (window.darkModeToggle) {
        window.darkModeToggle.setManualTheme(theme);
    }
};