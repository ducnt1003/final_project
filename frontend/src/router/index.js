import { createRouter, createWebHistory } from 'vue-router'
import { h, resolveComponent } from 'vue'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      // name: 'home',
      component: () => import('@/layouts/DefaultLayout.vue'),
      redirect: { name: 'Home' },
      children: [
        {
          path: '/home',
          name: 'Home',
          component: () => import('@/views/HomeView.vue'),
        },
        {
          path: '/courses',
          name: 'Courses',
          redirect: { name: 'CourseList' },
          component: {
            render() {
              return h(resolveComponent('router-view'))
            },
          },
          children: [
            {
              path: '',
              name: 'CourseList',
              component: () => import('@/views/Course/Courses.vue'),
            },
            {
              path: ':courseId',
              name: 'CourseDetail',
              component: () => import('@/views/Course/CourseDetail.vue'),
            },
          ]
        },
      ],
    },
  ]
})

export default router
