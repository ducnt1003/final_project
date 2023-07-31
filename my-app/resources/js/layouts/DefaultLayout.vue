<template>
    <div>
        <AppSidebar />
        <div className="wrapper d-flex flex-column min-vh-100 bg-light">
            <AppHeader />
            <div className="body flex-grow-1 px-3">
                <CContainer fluid>
                    <BackButton />
                    <router-view v-slot="{ Component }">
                        <transition name="fade" mode="out-in">
                            <component :is="Component" />
                        </transition>
                    </router-view>
                </CContainer>
            </div>
            <AppFooter />
        </div>
    </div>
</template>
<script>
import { CContainer } from "@coreui/vue";
import AppFooter from "@/components/AppFooter.vue";
import AppHeader from "@/components/AppHeader.vue";
import AppSidebar from "@/components/AppSidebar.vue";
import BackButton from "@/components/Common/BackButton.vue";
import { getAccessToken } from "@/utils/cookies";
import { me } from "@/services/auth";
import store from "@/store";

// import store from "@/store";
// import { mapActions, mapGetters } from 'vuex';

export default {
    name: "DefaultLayout",
    components: {
        AppFooter,
        AppHeader,
        AppSidebar,
        BackButton,
        CContainer,
    },
    setup() {
        // const token = ref();


        return {
            //   token,
        };
    },
    methods: {},
    computed: {
        // ...mapGetters(['getNotificationsCount']),
    },
    created() {},
    async beforeRouteEnter(to, from, next) {
        const token = await getAccessToken();

        // console.log(!token)
        if (!token) {
            return next({ name: "Login" });
        } else {
            const response = await me();
            if (response?.data) {
                store.dispatch("setUser", response.data);

                const user_role = response.data.user.role_id  ;
                if (user_role == 0) {
                    // return next({ name: 'Error', params: { pathMatch: 403 } });
                }
            }
            return next();
        }
    },
};
</script>
