import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/public.css', 'resources/css/public2.css', 'resources/js/app.js', 'resources/js/public.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Permite acessar do Windows
        hmr: {
            host: 'localhost', // Garante que o Hot Reload funcione
        },
        watch: {
            usePolling: true, // Força o sistema a verificar mudanças de arquivo (Correção para WSL)
        },
    },
});
