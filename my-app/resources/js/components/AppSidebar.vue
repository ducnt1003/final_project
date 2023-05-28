<template>
  <CSidebar
    position="fixed"
    :visible="sidebarVisible"
    @visible-change="
      (event) =>
        $store.dispatch({
          type: 'updateSidebarVisible',
          value: event,
        })
    "
  >
    <CSidebarBrand class="bg-white border">
      <router-link
        :to="{ name: 'Dashboard' }"
      >
        <img :src="logo" class="img-fluid" />
      </router-link>
    </CSidebarBrand>
    <AppSidebarNav />
  </CSidebar>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { AppSidebarNav } from './AppSidebarNav'
import logo from '@/assets/images/logo.jpg'
export default {
  name: 'AppSidebar',
  components: {
    AppSidebarNav,
  },
  setup() {
    const store = useStore()
    return {
      logo,
      sidebarVisible: computed(() => store.getters.sidebarVisible),
    }
  },
}
</script>
