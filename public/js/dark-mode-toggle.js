class DarkModeToggle {
    constructor() {
        this.darkModeToggle = document.getElementById('darkModeToggle');
        this.html = document.documentElement;
        this.init();
    }

    init() {
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        this.setTheme(currentTheme);
        
        // Add event listener
        if (this.darkModeToggle) {
            this.darkModeToggle.addEventListener('click', () => this.toggleTheme());
        }
    }

    setTheme(theme) {
        if (theme === 'dark') {
            this.html.classList.add('dark');
        } else {
            this.html.classList.remove('dark');
        }
        localStorage.setItem('theme', theme);
    }

    toggleTheme() {
        const isDark = this.html.classList.contains('dark');
        this.setTheme(isDark ? 'light' : 'dark');
        
        // Dispatch custom event for other components to listen
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: isDark ? 'light' : 'dark' }
        }));
    }

    getCurrentTheme() {
        return this.html.classList.contains('dark') ? 'dark' : 'light';
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.darkModeToggle = new DarkModeToggle();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DarkModeToggle;
}