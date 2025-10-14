@props(['size' => 'sm'])

@php
    $theme = Cookie::get('theme', 'light');
    $sizeClasses = match($size) {
        'sm' => 'w-8 h-8',
        'md' => 'w-10 h-10',
        'lg' => 'w-12 h-12',
        default => 'w-10 h-10'
    };
    $iconSize = match($size) {
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5'
    };
@endphp

<button
    type="button"
    class="flex items-center justify-center {{ $sizeClasses }} rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200"
    onclick="toggleTheme()"
    title="Toggle theme"
>
    <!-- Sun icon for light mode -->
    <svg
        class="{{ $iconSize }} text-gray-600 dark:text-gray-300 theme-icon light-icon {{ $theme === 'dark' ? 'hidden' : '' }}"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            fill-rule="evenodd"
            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
            clip-rule="evenodd"
        />
    </svg>

    <!-- Moon icon for dark mode -->
    <svg
        class="{{ $iconSize }} text-gray-600 dark:text-gray-300 theme-icon dark-icon {{ $theme === 'light' ? 'hidden' : '' }}"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
    </svg>
</button>

<script>
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    // Toggle the class on html element
    html.classList.toggle('dark');

    // Update cookie
    document.cookie = `theme=${newTheme}; path=/; max-age=${60 * 24 * 365}`;

    // Update icons
    updateThemeIcons(newTheme);

    // Dispatch custom event for other components
    window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: newTheme } }));
}

function updateThemeIcons(theme) {
    const lightIcons = document.querySelectorAll('.light-icon');
    const darkIcons = document.querySelectorAll('.dark-icon');

    if (theme === 'dark') {
        lightIcons.forEach(icon => icon.classList.add('hidden'));
        darkIcons.forEach(icon => icon.classList.remove('hidden'));
    } else {
        lightIcons.forEach(icon => icon.classList.remove('hidden'));
        darkIcons.forEach(icon => icon.classList.add('hidden'));
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const theme = getCookie('theme') || 'light';
    updateThemeIcons(theme);

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    }
});

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
</script>

<style>
.theme-icon {
    transition: opacity 0.2s ease-in-out;
}

.theme-icon.hidden {
    opacity: 0;
    pointer-events: none;
}

button:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}
</style>