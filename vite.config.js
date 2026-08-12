import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: 'assets/dist',
    emptyOutDir: true,
    rollupOptions: { input: 'assets/src/main.js', output: { entryFileNames: 'app.js', assetFileNames: asset => asset.name?.endsWith('.css') ? 'app.css' : 'assets/[name]-[hash][extname]' } }
  }
});

