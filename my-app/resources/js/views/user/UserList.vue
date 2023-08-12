<template>
    <ContentCard>
        <template #title>{{ $t("users.list.title") }}</template>

        <div class="d-flex justify-content-end mb-3">
            <CButton
                color="success"
                class="text-white"
                @click="
                    () =>
                        $router.push({
                            name: 'UserCreate',
                        })
                "
            >
                Người dùng mới
            </CButton>
        </div>

        <!-- Table -->
        <DataTable
            :columns="columns"
            :datas="datas"
            :queries="queries"
            :filters="filters"
            :pages="pages"
            :isLoading="isLoading"
            :defaultSort="defaultSort"
            clickable
            @viewClick="handleView"
        />
    </ContentCard>
</template>

<script>
import ContentCard from "@/components/Common/ContentCard.vue";
//   import * as units from '@/configs/users/Unit'
//   import * as positions from '@/configs/users/Position'
import DataTable from "@/components/Common/DataTable.vue";
import { ref } from "@vue/reactivity";
import { getUsers } from "../../services/user";

export default {
    name: "UserList",
    components: {
        ContentCard,
        DataTable,
    },
    setup() {
        const columns = [];
        const queries = ref({});
        const filters = ref([]);
        const isLoading = ref(false);
        const datas = ref([]);
        const pages = ref(1);
        const defaultSort = ["id", "asc"];

        return {
            columns,
            queries,
            filters,
            datas,
            pages,
            isLoading,
            defaultSort,
        };
    },
    methods: {
        setColumns() {
            this.columns = [
                //   { data: 'id', title: this.$t('users.common.id'), sortable: true },
                {
                    data: "name",
                    title: this.$t("users.common.fullname"),
                    sortable: false,
                },
                { data: "school", title: "Trường", sortable: false },
                {
                    data: "email",
                    title: "Email",
                    sortable: false,
                },
                {
                    data: "role",
                    title: "Vai trò",
                    sortable: false,
                },
            ];
        },
        setFilters() {
            this.filters = [
                {
                    data: "search",
                    type: "CFormInput",
                    label: this.$t("common.fullName"),
                },
                {
                    data: "mail",
                    type: "CFormInput",
                    label: "Email",
                },
            ];
        },
        setQueries() {
            this.queries = this.$route.query;
        },
        async handleGetData() {
            // TODO: Call api to get data here
            this.isLoading = true;
            this.pages = 1;
            try {
                const response = await getUsers(this.queries);
                if (response) {
                    this.datas = response.data.data;
                    this.pages = response.data.pagination.total_pages;
                }
            } finally {
                this.isLoading = false;
            }
        },
        handleView(event) {
            this.$router.push({ name: "UserInfo", params: { id: event.id } });
        },
    },
    async created() {
        this.setFilters();
        this.setColumns();

        this.setQueries();
        await this.handleGetData();

        // watch query change
        this.$watch(
            () => this.$route.query,
            async () => {
                if (this.$route.name === "UserList") {
                    this.setQueries();
                    await this.handleGetData();
                }
            }
        );
    },
};
</script>
