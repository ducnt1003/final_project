import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";
import nProgress from 'nprogress'

const router = new createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  // Start NProgress UI
  nProgress.start();

  return next();
});

router.afterEach((to) => {
  // Finish NProgress UI
  nProgress.done();
});

export default router;
