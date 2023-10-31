import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import fs from 'fs';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        https: {
            key: fs.readFileSync('docker/certificates/apache/docker.dev.key'),
            cert: fs.readFileSync('docker/certificates/apache/docker.dev.crt'),
        },
        host: true,
        port: 7037,
        hmr: {
            host: 'dualnets.docker.dev',
            protocol: 'wss'
        },
    },

});
