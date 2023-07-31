<template>
    <CCard class="btn btn-light h-100">
      <CCardBody
        class="d-flex flex-column align-items-center justify-content-center"
      >
        <h2>
          {{ quantity }}
          <font-awesome-icon :icon="`fa-solid ${icon}`" size="xs" />
        </h2>
        <h6 class="m-0 text-uppercase fw-bold">
          {{ title }}
        </h6>
      </CCardBody>

      <router-link :to="{ name: pathName }" class="stretched-link"> </router-link>
    </CCard>
  </template>

  <script>
  export default {
    name: "DashboardLinkCard",
    props: {
      title: {
        type: String,
        required: true,
      },
      quantity: {
        type: Number,
        required: false,
        default: 0,
      },
      pathName: {
        type: String,
        required: true,
      },
      icon: {
        type: String,
        required: true,
      },
    },
  };
  </script>
