import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/newhome/css/app.css', 'resources/newhome/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
