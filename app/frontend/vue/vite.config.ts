import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    host: true,      // чтобы слушать 0.0.0.0, если нужно
    port: 20180,     // порт по желанию
  },
})
