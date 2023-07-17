<template>
  <CDropdown variant="dropdown">
    <CDropdownToggle :caret="false" class="btn-link shadow-none nav-link">
      <font-awesome-icon icon="fa-solid fa-user" class="ms-2" size="lg" />
    </CDropdownToggle>

    <CDropdownMenu class="p-0">
      <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
        {{ $t("dropdown.greeting") }}, {{ user.name }}.
      </CDropdownHeader>

      <!-- <router-link
        :to="{ name: 'UserInfo', params: { id: user.id } }"
        class="dropdown-item py-2"
      >
        <font-awesome-icon icon="fa-solid fa-user" /> {{ $t("dropdown.info") }}
      </router-link> -->

      <CDropdownDivider class="m-0" />

      <a @click="logout" role="button" class="dropdown-item py-2">
        <font-awesome-icon icon="fa-solid fa-right-from-bracket" />
        {{ $t("dropdown.logout") }}
      </a>
    </CDropdownMenu>
  </CDropdown>
</template>

<script>
import { useStore } from "vuex";
// import { logout } from "@/services/auth";
import { removeAccessToken } from "@/utils/cookies";
import { mapActions } from "vuex";


export default {
  name: "AppHeaderDropdownAccnt",
  setup() {
    const user = useStore().state.Auth.user;

    return {
      user,
    };
  },
  methods: {
    // ...mapActions(["removeNotification"]),
    async logout() {
    //   await logout();
      removeAccessToken({ path: "/" });
      removeSelectedDevices();
      removeAuthen2fa();
      this.removeNotification();
      this.$router.push({ name: "Login" });
    },
  },
};
</script>
<style scoped>
.dropdown-item.active,
.dropdown-item:active {
  color: unset !important;
  text-decoration: none;
  background-color: white !important;
}
</style>
