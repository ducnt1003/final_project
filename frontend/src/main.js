// import './assets/main.css'

import { createApp } from "vue";
import CoreuiVue from "@coreui/vue";
import App from "./App.vue";
import router from "./router";
import "nprogress/nprogress.css";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp(App);

app.use(router);
app.use(CoreuiVue);
app.use(Toast, {
  pauseOnFocusLoss: false,
  hideProgressBar: true,
});

app.mount("#app");
