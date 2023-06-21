import { h, resolveComponent } from 'vue'
import i18n from '@/i18n/i18n'

const { t } = i18n.global

const routes = [
    {
      /** Full page layout routes */
      path: '/',
      name: 'Home',
      component: () => import('@/layouts/DefaultLayout.vue'),
      redirect: { name: 'Dashboard' },
      meta: {
        title: t('home.title')
      },
      children: [
        {
          path: '/dashboard',
          name: 'Dashboard',
          component: () => import('@/views/Dashboard.vue'),
          meta: {
            title: "Dashboard",
          },
        },
        {
          path: '/courses',
          name: 'Course',
          component: () => import('@/views/course/CourseList.vue'),
          meta: {
            title: "Dashboard",
          },
        },
      ],
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/views/auth/Login.vue'),
      meta: {
        title: t('auth.login.title'),
      },
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'Error',
      component: () => import('@/views/error/Error.vue'),
      meta: {
        title: t('errors.common.title'),
      },
    },
]

export default routes
