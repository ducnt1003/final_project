<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <CHeaderToggler class="ps-1" @click="$store.dispatch('toggleSidebar')">
        <font-awesome-icon icon="fa-solid fa-bars" />
      </CHeaderToggler>
      <CHeaderNav class="ms-auto">
        <!-- <CButton
        id="language_button"
        class="btn-link shadow-none nav-link"
        >
          <font-awesome-icon icon="fa-solid fa-globe" class="mx-2" size="lg" />
        </CButton> -->

        <!-- <AppHeaderDropdownNotis /> -->

        <AppHeaderDropdownAccnt />
      </CHeaderNav>
    </CContainer>
    <CHeaderDivider />
    <CContainer fluid>
      <AppBreadcrumb />
    </CContainer>
  </CHeader>
</template>

<script>
import AppBreadcrumb from "./AppBreadcrumb.vue";
import AppHeaderDropdownAccnt from "./AppHeaderDropdownAccnt.vue";
// import AppHeaderDropdownNotis from "./AppHeaderDropDownNotis.vue";
export default {
  name: "AppHeader",
  components: {
    AppBreadcrumb,
    AppHeaderDropdownAccnt,
    // AppHeaderDropdownNotis,
  },
  setup() {
    return {};
  },
};
</script>
