import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')
export default {
    presets: [
        preset,
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './app/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ],

    theme: {
        extend: {
            colors: {
                'srx-blue': "#2F69B0",
                'srx-green': "#32C551",
                'srx-white': "#F7F6F5",
                'srx-dark-blue': "#1B2437",
            },
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
            textColor: {'srx-black': "#222222"},
        },
    },

    plugins: [forms],
};
