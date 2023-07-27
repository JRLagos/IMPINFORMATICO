import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

<<<<<<< HEAD
// Jorge Lagos
=======

//Mario
>>>>>>> e5fb95d765fd8508acc21abea307280f2bc96d62
