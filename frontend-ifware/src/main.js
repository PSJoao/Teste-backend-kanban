// src/main.js

import { createApp } from 'vue'
import App from './App.vue'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import router from './router';
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css' // Importe os ícones

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi', // Define o conjunto de ícones padrão
  },
})

createApp(App).use(router).use(vuetify).mount('#app');