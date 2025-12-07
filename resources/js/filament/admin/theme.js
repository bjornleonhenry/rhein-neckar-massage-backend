// Theme toggle handler for Filament admin panel
const getTheme = () => {
    const cookieValue = document.cookie
        .split('; ')
        .find((row) => row.startsWith('theme='))
        ?.split('=')[1];
    return cookieValue || 'light';
};

const applyTheme = () => {
    const isDark = getTheme() === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    
    // Also update the data attribute if Filament uses it
    if (isDark) {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.removeAttribute('data-theme');
    }
};

// Apply theme on initial load
document.addEventListener('DOMContentLoaded', () => {
    applyTheme();
});

// Re-apply theme when toggled (if your toggle widget dispatches this event)
document.addEventListener('theme-changed', () => {
    applyTheme();
});

// Watch for Livewire navigation in SPA mode
document.addEventListener('livewire:navigated', () => {
    applyTheme();
});

// Initial application before DOMContentLoaded (in case of fast load)
applyTheme();
