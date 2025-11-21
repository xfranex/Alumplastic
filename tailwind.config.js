import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [ //dice a tailwind dónde buscar clases CSS usadas,analiza los archivos para hacer un CSS con las clases necesarias, aplica el purgado y lo optimiza
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans], //fuente predeterminada
            },
        },
    },

    plugins: [forms],
};
