<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :lg="12" class="text-center">
          <div>
            <h1 style="font-size: 10rem">
              {{ $t(`errors.${errorCode}.code`) }}
            </h1>
            <h4 class="pt-3">{{ $t(`errors.${errorCode}.name`) }}</h4>
            <p>{{ $t(`errors.${errorCode}.description`) }}</p>
          </div>

          <router-link
            :to="{ name: 'Home' }"
            class="btn btn-primary px-4 px-sm-5 py-2 py-sm-3 mt-3"
          >
            <span class="fs-5">{{ $t('errors.common.toHome') }}</span>
          </router-link>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
export default {
  name: 'Error',
  data() {
    return {
      errorCode: '404',
      displayedErrors: ['400', '401', '403', '404', '500', '503'],
    }
  },
  mounted() {
    this.updateErrorPage()
  },
  updated() {
    this.updateErrorPage()
  },
  methods: {
    updateErrorPage() {
      const errorParams = this.$route?.params?.pathMatch
      
      this.errorCode = this.displayedErrors.includes(errorParams)
        ? errorParams
        : '404'
    },
  },
}
</script>
