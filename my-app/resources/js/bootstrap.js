import loadash from 'lodash'
window._ = loadash

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import i18n from './i18n/i18n'

import CoreuiVue from '@coreui/vue'
import 'nprogress/nprogress.css'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'
import VueViewer from 'v-viewer'
import 'viewerjs/dist/viewer.min.css'
// import Loading from "@/components/Common/Loading.vue"
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import "@/assets/icons"

const app = createApp(App)
app.use(store)
app.use(router)
app.use(i18n)
app.use(CoreuiVue)
app.use(Toast, {
    pauseOnFocusLoss: false,
    hideProgressBar: true,
  })
app.use(VueViewer)
app.component('font-awesome-icon', FontAwesomeIcon)
app.component('Multiselect', Multiselect)
// app.component("Loading", Loading)

app.mount('#app')
