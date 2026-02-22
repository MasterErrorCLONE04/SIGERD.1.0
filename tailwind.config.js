import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import colors from 'tailwindcss/colors'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php', // 👈 faltaba esta
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                gray: {
                    ...colors.gray,
                    900: 'var(--color-gray-900, #111827)',
                    800: 'var(--color-gray-800, #1f2937)',
                    700: 'var(--color-gray-700, #374151)',
                    600: 'var(--color-gray-600, #4b5563)',
                    400: 'var(--color-gray-400, #9ca3af)',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
}
