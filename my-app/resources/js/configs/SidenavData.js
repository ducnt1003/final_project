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
    name: t('sidebar.devices'),
    to: '/devices',
    icon: 'fa-solid fa-desktop',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.requests'),
    to: '/requests',
    icon: 'fa-solid fa-comment-dots',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.handovers'),
    to: '/handovers',
    icon: 'fa-solid fa-file-signature',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.users'),
    to: '/users',
    icon: 'fa-solid fa-user',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.inventoryReports'),
    to: '/inventory-reports',
    icon: 'fa-solid fa-clipboard',
  },
  {
    component: 'CNavGroup',
    name: t('sidebar.errorReports'),
    to: '/error-reports',
    icon: 'fa-solid fa-triangle-exclamation',
  },
]
