import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dns from 'node:dns';


dns.setDefaultResultOrder('verbatim');
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/scripts.js',
                'resources/js/app.js',
                'resources/js/litepicker.js',
                'resources/js/scripts.js',
                'resources/js/toasts.js',
                'resources/js/markdown.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
      },
    base: '/'
      
});

