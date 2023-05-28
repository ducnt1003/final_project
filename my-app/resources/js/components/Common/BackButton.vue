<template>
  <template v-if="dislpayBackButton">
    <CButton
      id="back_button" 
      color="link"
      @click="handleClick"
      class="ps-0 shadow-none link-dark text-decoration-none fw-bold"
    >
      <font-awesome-icon icon="fa-solid fa-chevron-left" class="me-1" />
      {{ $t("common.back") }}
    </CButton>
  </template>
</template>

<script>
export default {
  name: "BackButton",
  setup() {
    return {};
  },
  methods: {
    handleClick() {
      // check if current tab have previous pages
      if (this.$router.options.history.state.back) {
        this.$router.go(-1);
      } else {
        this.$router.push({ name: "Home" });
      }
    },
  },
  computed: {
    dislpayBackButton() {
      return this.$route.meta?.backButton;
    },
  },
};
</script>
