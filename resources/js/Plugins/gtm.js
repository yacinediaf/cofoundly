import { router } from '@inertiajs/vue3'

export default {
  install(app) {
    router.on('navigate', (event) => {
      if (window.dataLayer) {
        window.dataLayer.push({
          event: 'inertia-pageview',
          page_path: event.detail.page.url,
          page_title: document.title,
        })
      }
    })
  },
}
