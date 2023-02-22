// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    modules: [
        '@nuxtjs/tailwindcss',
        [
            '@pinia/nuxt',
            {
                autoImports: ['defineStore', 'acceptHMRUpdate'],
            },
        ],
    ],
    tailwindcss: {
        cssPath: '~/assets/css/tailwind.css',
        configPath: 'tailwind.config.js',
    },
    app: {
        head: {
          charset: 'utf-8',
          viewport: 'width=device-width, initial-scale=1, user-scalable=no', 
          title: 'Arfan Test',
          meta: [
            { name: 'description', content: 'Arfan Test CRUD - TKDN' },
            { name: 'og:title', content: 'Arfan Test' },
            { name: 'og:description', content: 'Arfan Test CRUD - TKDN' },
          ],
          link: [],
          script: [],
          htmlAttrs: {
            lang: 'id',
          }
        },
    },
    runtimeConfig: {
        web: process.env.APP_API,
        public: {
            web: process.env.APP_API,
        }
    }
})
