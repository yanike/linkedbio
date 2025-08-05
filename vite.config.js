import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    VitePWA({
      injectRegister: 'auto',
      registerType: 'autoUpdate',
      manifest: {
        name: 'linkedb.io',
        short_name: 'linkedb.io',
        description: 'Your corner of the internet! Create your own link in bio page.',
        theme_color: '#ffffff',
        background_color: '#ffffff',
        display: 'standalone',
        start_url: '/',
        icons: [
          {
            src: '/linkedbio_logo.jpg',
            sizes: '192x192',
            type: 'image/jpg',
            purpose: 'maskable',

          },
          {
            src: '/linkedbio_logo.jpg',
            sizes: '512x512',
            type: 'image/jpg',
            purpose: 'any',

          },
        ],
      },
      srcDir: 'public', // Set the source directory to public
      outDir: 'public', // Set the output directory to public
      devOptions: {
        enabled: true,
      },
    }),
  ],
});
