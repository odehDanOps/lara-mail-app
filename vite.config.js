import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/notiflix-3.2.7.min.css',
                'resources/js/app.js',
                'resources/js/notiflix-3.2.7.min.js',
            ],
            refresh: true,
        }),
    ],
});
