import { defineConfig } from 'vite';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/js/app.js',
            'resources/css/app.css',
        ]),
        svelte(),
    ],
    optimizeDeps: {
        include: [
            "@inertiajs/inertia",
            "@inertiajs/inertia-svelte",
        ]
    }
});
