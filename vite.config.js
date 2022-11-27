import { defineConfig } from 'vite';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import laravel from 'laravel-vite-plugin';
import path from "path";

export default defineConfig({
    plugins: [
        laravel([
            'resources/js/app.js',
            'resources/css/app.css',
        ]),
        svelte({
            prebundleSvelteLibraries: true,
        }),
    ],
    optimizeDeps: {
        include: [
            "@inertiajs/inertia",
            "@inertiajs/inertia-svelte",
        ]
    },
    resolve:{
        alias:{
            '@' : path.resolve(__dirname, './resources/js')
        },
    },
});
