import {defineConfig} from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'url';

export default defineConfig({
    plugins: [
        // ssr({
        //     baseAssets: '/dist'
        // }),
        laravel({
            input: ['resources/js/main.js'],
            buildDirectory: 'dist',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: 'dist',
                }
            }
        }),
    ],
    resolve: {
        alias: {
                '@': '/resources/js',
        }
    },
    define: {
        __VUE_PROD_DEVTOOLS__: true,
    },
    build: {
        sourcemap: true,
        rollupOptions: {
            output: {
                chunkFileNames: 'js/[name]-[hash].js',
                entryFileNames: 'js/[name]-[hash].js',
                assetFileNames: ({name}) => {
                    if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')){
                        return 'images/[name]-[hash][extname]';
                    }

                    if (/\.css$/.test(name ?? '')) {
                        return 'css/[name]-[hash][extname]';
                    }

                    if (/\.(woff|woff2|ttf|otf|eot)$/.test(name ?? '')) {
                        return 'fonts/[name]-[hash][extname]';
                    }
                    // default value
                    return 'assets/[name]-[hash][extname]';
                },
            },
        }
    },
});