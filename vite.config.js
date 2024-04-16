import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';
import {viteStaticCopy} from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/hts-appteam-livewire/appteam-livewire.js',
                'resources/sass/hts-appteam-livewire/appteam-livewire.scss'
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
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~fontawesome': path.resolve(__dirname, 'node_modules/@fortawesome/fontawesome-free')
        }
    },
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
