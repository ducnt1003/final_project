<template>
  <CBreadcrumb class="d-md-down-none me-auto mb-0">
    <template v-for="item in breadcrumbs" :key="item">
      <li :class="['breadcrumb-item', { active: item.active }]">
        <router-link :to="{ name: item.name }" v-if="!item.active">
          {{ item.title }}
        </router-link>
        <span v-else>{{ item.title }}</span>
      </li>
    </template>
  </CBreadcrumb>
</template>

<script>
import { onMounted, ref, computed, watch } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

export default {
  name: 'AppBreadcrumb',
  setup() {
    const breadcrumbs = ref()
    const router = useRouter()
    const store = useStore()
    const dynamicBreadcrumbs = computed(() => store.getters.dynamicBreadcrumbs)
    const getBreadcrumbs = () => {
      return router.currentRoute.value.matched.map((route) => {
        return {
          active: route.name === router.currentRoute.value.name,
          name: route.name,
          title: setDynamicTitle(route.name) || route.meta.title || route.name,
          path: `${router.options.history.base}${route.path}`,
        }
      })
    }

     // For dynamic title use
    const setDynamicTitle = (name) => {
      if (dynamicBreadcrumbs.value.length > 0) {
        const dynamicBreadcrumb = dynamicBreadcrumbs.value.find(
          (breadcrumb) => breadcrumb.name === name,
        )

        if (!!dynamicBreadcrumb && Object.keys(dynamicBreadcrumb).length > 0) {
          return `${dynamicBreadcrumb.data.id} - ${dynamicBreadcrumb.data.name}`
        } else {
          return null
        }
      } else {
        return null
      }
    }


    router.afterEach(() => {
      breadcrumbs.value = getBreadcrumbs()
    })

    onMounted(() => {
      breadcrumbs.value = getBreadcrumbs()
    })

    watch(
      () => dynamicBreadcrumbs.value,
      () => {
        breadcrumbs.value = getBreadcrumbs()
      },
    )

    return {
      breadcrumbs,
    }
  },
}
</script>
