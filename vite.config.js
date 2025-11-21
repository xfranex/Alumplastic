import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    publicDir: 'public',
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/productos/app.jsx'], //indica que archivos vite debe compilar
            refresh: true,
        }),
    ],
});
