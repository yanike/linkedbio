import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    import('vite-plugin-pwa').then(({ VitePWA }) => VitePWA({
      registerType: 'autoUpdate',
      manifest: {
        name: 'LinkedBi.o',
        short_name: 'LinkedBi.o',
        description: 'Your corner of the internet! Create your own link in bio page.',
        theme_color: '#FFFFFF',
        background_color: '#FFFFFF',
        display: 'standalone',
        start_url: '/',
        icons: [
          {
            src: '/linkedbio_logo.jpg',
            sizes: '192x192',
            type: 'image/jpeg',
          },
          {
            src: '/linkedbio_logo.jpg',
            sizes: '512x512',
            type: 'image/jpeg',
          },
        ],
      },
      devOptions: {
        enabled: true,
      },
    })),
  ],
});
