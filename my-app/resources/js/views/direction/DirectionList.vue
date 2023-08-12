<template>
    <ContentCard>
        <template #title> Danh sách định hướng </template>

        <div class="d-flex justify-content-end mb-3">
            <CButton
                color="success"
                class="text-white"
                @click="
                    () =>
                        $router.push({
                            name: 'DirectionCreate',
                        })
                "
            >
                Định hướng mới
            </CButton>
        </div>

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
            :hasEdit="true"
            @editClick="handleEdit"
            :hasDelete="true"
            @deleteClick="handleDelete"
        >
        </DataTable>
    </ContentCard>
</template>
<script>
import ContentCard from "@/components/Common/ContentCard.vue";
import DataTable from "@/components/Common/DataTable.vue";
import { useRoute } from "vue-router";
import { ref } from "@vue/reactivity";
import { mapActions } from "vuex";
import { useToast } from "vue-toastification";
import { getDirections } from "../../../../../frontend/src/services/direction";
export default {
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
        const categoryId = useRoute().params.categoryId;
        const categoryData = ref(null);
        const toast = useToast();

        return {
            columns,
            queries,
            filters,
            isLoading,
            datas,
            pages,
            defaultSort,
            categoryId,
            categoryData,
            toast,
        };
    },
    methods: {
        ...mapActions(["showDialog"]),
        setColumns() {
            this.columns = [
                {
                    data: "name",
                    title: "Tên định hướng",
                    sortable: true,
                },
                {
                    data: "expert_name",
                    title: "Chuyên gia",
                    sortable: true,
                },
                {
                    data: "interested",
                    title: "Số người quan tâm",
                    sortable: true,
                },
            ];
        },
        setFilters() {
            this.filters = [
                {
                    data: "name",
                    type: "CFormInput",
                    label: "Tên định hướng",
                },
                {
                    data: "expert",
                    type: "CFormInput",
                    label: "Chuyên gia",
                },
            ];
        },
        setQueries() {
            this.queries = this.$route.query;
        },
        async handleGetData() {
            this.isLoading = true;
            this.pages = 1;

            // TODO: Call api to get data here
            try {
                const response = await getDirections(this.queries);
                this.datas = response.data.data;
                this.pages = response.data.pagination.total_pages;
            } finally {
                this.isLoading = false;
            }
        },
        handleView(event) {
            this.$router.push({
                name: "DirectionDetail",
                params: { directionId: event.id },
            });
        },
        handleEdit(event) {
            this.$router.push({
                name: "DirectionEdit",
                params: { directionId: event.id },
            });
        },
        handleDelete(event) {
            this.showDialog({
                callback: async () => {
                    // TODO: add api here to delete device
                    await new Promise((resolve) => {
                        console.log("Handle delete id", event.id);

                        setTimeout(() => {
                            resolve();
                        }, 1000);
                    });

                    this.toast.success(this.$t("common.deleteSuccessMessage"));

                    if (this.datas.length <= 1 && this.currentPage > 1) {
                        this.$router.push({
                            query: {
                                ...this.queries,
                                page: this.currentPage - 1,
                            },
                        });
                    } else {
                        this.handleGetData();
                    }
                },
            });
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
                if (this.$route.name === "DirectionList") {
                    this.setQueries();
                    await this.handleGetData();
                }
            }
        );
    },
};
</script>
