import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://knhs.in',
  integrations: [
    sitemap({
      // exclude the Supabase demo page and examDemo app from generated sitemap
      filter: (url) => !url.includes('/apps/supabase') && !url.includes('/apps/examDemo')
    })
  ]
});
