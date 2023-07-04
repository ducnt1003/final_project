<template>
  <CCard>
    <CCardBody>
      <!-- Page Title -->
      <CCardTitle component="h2" class="mb-4">
        <slot name="title">{{ title }}</slot>
      </CCardTitle>

      <slot></slot>
    </CCardBody>
  </CCard>
</template>

<script>
import router from '@/router'

export default {
  name: 'ContentCard',
  setup() {
    return {
      title: router.currentRoute.value.meta.title,
    }
  },
}
</script>
