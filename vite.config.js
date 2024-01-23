import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import fs from 'fs';
import {viteStaticCopy} from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/flag-icons/css/flag-icons.min.css',
                    dest: 'images/flags'
                },
                {
                    src: 'node_modules/flag-icons/flags/**/*',
                    dest: 'images/flags'
                }
            ]
        }),
    ],
    server: {
        https: {
            key: fs.readFileSync('docker/certificates/apache/docker.dev.key'),
            cert: fs.readFileSync('docker/certificates/apache/docker.dev.crt'),
        },
        host: true,
        port: 7038,
        hmr: {
            host: 'dualnets.docker.dev',
            protocol: 'wss'
        },
    },

});
