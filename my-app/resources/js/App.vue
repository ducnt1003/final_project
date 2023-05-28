<!--
* File name: App.vue
* Description: App layout page
* Author: COWELL LinhDH
* Creation date: 2021/04/05
-->

<template>
  <router-view v-slot="{ Component }">
    <transition name="fade" mode="out-in">
      <component :is="Component"></component>
    </transition>
  </router-view>
</template>

<script>


export default {

}
</script>

<style lang="scss">
// Import Main styles for this application
@import './styles/style';
</style>
