// import './assets/main.css'

import { createApp } from 'vue'
import CoreuiVue from '@coreui/vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)
app.use(CoreuiVue)

app.mount('#app')
