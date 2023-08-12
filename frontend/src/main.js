// import './assets/main.css'

import { createApp } from "vue";
import CoreuiVue from "@coreui/vue";
import App from "./App.vue";
import router from "./router";
import "nprogress/nprogress.css";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import Loading from "@/components/Loading.vue"
import store from './store'


const app = createApp(App);

app.use(router);
app.use(CoreuiVue);
app.use(store)
app.use(Toast, {
  pauseOnFocusLoss: false,
  hideProgressBar: true,
});
app.component("Loading", Loading)

app.mount("#app");
