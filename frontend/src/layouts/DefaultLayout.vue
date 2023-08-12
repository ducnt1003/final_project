<template>
  <div>
    <Header></Header>
    <router-view v-slot="{ Component }">
      <transition name="fade" mode="out-in">
        <component :is="Component"></component>
      </transition>
    </router-view>
    <Footer></Footer>
  </div>
</template>

<script >
import Footer from "@/components/Footer.vue";
import Header from "@/components/Header.vue";
import { me } from "../services/auth";
import store from "@/store";
import { getAccessToken } from '@/utils/cookies'

export default {
  name: 'DefaultLayout',
  components: {
    Footer,
    Header,
  },
  
  async beforeRouteEnter(to, from, next) {
      const token = await getAccessToken();
      if (!!token) {
        const response = await me();
        store.dispatch("setUser", response.data);
        // if (response.data.user.role_id != 0) {
        //   return next({ name: "Login" });
        // }
      } 
      return next();
  }
};


</script>

