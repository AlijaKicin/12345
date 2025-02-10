import { createApp } from 'vue' // Promjena na Vue 3 sintaksu
import App from './App.vue'
import router from './router'

createApp(App) // Koristi createApp za Vue 3
  .use(router) // Dodaj router
  .mount('#app') // Montiraj aplikaciju na element s id="app"

// Vue.config.productionTip is not needed in Vue 3
