import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/mdb.min.css',
                'resources/css/mdb.rtl.min.css',
                'resources/js/app.css',
                'resources/js/bootstrap.js',
                'resources/js/mdb.es.min.js',
                'resources/js/mdb.umd.min.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
