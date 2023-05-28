import { createRouter, createWebHistory } from 'vue-router'
import i18n from '../i18n/i18n'
import routes from './routes'
import nProgress from 'nprogress'

const router = new createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
})

router.beforeEach((to, from, next) => {
  // Remove last trailing slashes
  if (/\/{1,}$/.test(to.fullPath)) {
    return next(to.fullPath.replace(/\/{1,}$/, ''))
  }

  // Start NProgress UI
  nProgress.start()

  return next();
})

router.afterEach((to) => {
  /* Set document title from route meta */
  const defaultDocumentTitle = i18n.global.t('defaultTitle')

  if (to?.meta?.title) {
    document.title = `${to.meta.title} — ${defaultDocumentTitle}`
  } else {
    document.title = defaultDocumentTitle
  }

  // Finish NProgress UI
  nProgress.done()
})

export default router
