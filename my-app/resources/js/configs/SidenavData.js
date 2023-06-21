import i18n from '@/i18n/i18n'
const { t } = i18n.global

export default [
  {
    component: 'CNavItem',
    name: t('sidebar.dashboard'),
    to: '/dashboard',
    icon: 'fa-solid fa-home',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.courses'),
    to: '/courses',
    icon: 'fa-solid fa-book',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.users'),
    to: '/users',
    icon: 'fa-solid fa-user',
  },
]
