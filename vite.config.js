import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/assets/sass/vars.scss','resources/assets/sass/style.scss', 'resources/css/reset.css', 'resources/js/app.js'],
            refresh: true,
        }),
        
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            '@components': 'resources/js/components',
        },
    },
});