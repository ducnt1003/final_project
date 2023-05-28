<template>
  <CDropdown variant="dropdown">
    <CDropdownToggle :caret="false" class="btn-link shadow-none nav-link">
      <font-awesome-icon
        icon="fa-solid fa-bell"
        class="position-relative ms-2"
        size="lg"
        @click="handleClickNotification"
      />
      <span class="badge" v-if="this.getNotificationsCount > 0">{{
        getNotificationsCount
      }}</span>
    </CDropdownToggle>

    <CDropdownMenu class="p-0">
      <!-- TODO: show notifications -->
      <template v-if="!isLoading && datas.length > 0">
        <div v-for="data in datas" class="border">
          <a @click="handleClickCell(data)" role="button" class="dropdown-item py-2">
            <div class="d-flex">
              <div class="position-relative px-2 me-2">
                <template v-if="data.is_read == 0">
                  <span
                    class="position-absolute top-50 start-50 translate-middle p-1 bg-info rounded-circle"
                  >
                  </span>
                </template>
              </div>
              <blockquote class="blockquote fs-6">
                <div class="flex-fill">
                  <p
                    :class="`line-clamp m-0 ${
                      data.is_read == 0 ? 'fw-bold' : ''
                    }`"
                    style="width:280px"
                  >
                    <small>{{ data.content }}</small>
                  </p>
                </div>
                <div>
                  <p :class="`m-0 ${data.is_read == 0 ? 'text-dark' : 'text-secondary'}`">
                    <small>{{ data.time }}</small>
                  </p>
                </div>
              </blockquote>
            </div>
          </a>
        </div>
      </template>
      <template v-else>
        <CCardBody>
          <template v-if="isLoading">
            <Loading />
          </template>
          <template v-if="!isLoading && datas.length < 1">
            <div class="text-center">
              <img :src="noNitification" class="img-fluid" style="max-width: 320px" />
            </div>
          </template>
        </CCardBody>
      </template>
      <CDropdownDivider class="m-0" />

      <a
        @click="notifications"
        role="button"
        class="dropdown-item py-2"
        style="color: blue; text-align: center"
      >
        {{ $t("dropdown.notifications") }}
      </a>
    </CDropdownMenu>
  </CDropdown>
</template>

<script>
import { useStore } from "vuex";
// import { getNotifications, getRead, getSeen } from "@/services/notification";
import { ref } from "@vue/reactivity";
import { mapGetters, mapActions } from "vuex";
// import noNitification from '@/assets/images/no-notification.jpg';

export default {
  name: "AppHeaderDropdownNotis",
  setup() {
    const user = useStore().state.Auth.user;
    const datas = ref([]);
    const isLoading = ref(false);
    const data = ref({});

    return {
      user,
      datas,
      isLoading,
      data,
    //   noNitification,
    };
  },
  methods: {
    // ...mapActions(["setNotification"]),
    async handleGetData() {
      this.isLoading = true;
      try {
        this.data = {
          itemsPerPage: 3,
        };
        // const response = await getNotifications(this.data);
        // if (response) {
        //   this.datas = response.data.data;
        //   if (this.datas.length > 0)
        //     this.setNotification(this.datas[0].countNotSeen);
        // }
      } finally {
        this.isLoading = false;
      }
    },
    async notifications() {
      this.$router.push({ name: "Notifications" });
    },
    async handleClickNotification() {
      try {
        this.setNotification(0);
        await getSeen(this.user.id);
        const response = await getNotifications(this.data);
        if (response) {
          this.datas = response.data.data;
        }
      } catch (error) {
        console.error(error);
      }
    },
    async handleClickCell(value) {
      try {
        const data = {
          notification_id: value.id,
        };
        const response = getRead(data);
        if (response) {
          const chosenIndex = this.datas.findIndex((val) => val.id === value.id);

          this.datas[chosenIndex].is_read = true;

          this.$router.push({
            name: value.to.name,
            params: value.to.params.reduce(
              (obj, item) => Object.assign(obj, { [item.name]: item.value }),
              {}
            ),
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
  computed: {
    ...mapGetters(["getNotificationsCount"]),
  },
  async created() {
    this.isLoading = true;

    await this.handleGetData(), (this.isLoading = false);
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
.badge {
  background-color: red;
  color: white;
  border-radius: 50%;
  padding: 3px 6px;
  position: absolute;
  top: 1px;
  right: -4px;
}
.line-clamp {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
  white-space: normal;
}
</style>
