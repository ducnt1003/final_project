<template>
    <ContentCard>
        <template #title> Danh sách danh mục </template>

        <div class="d-flex justify-content-end mb-3">
            <CButton
                color="success"
                class="text-white"
                @click="
                    () =>
                        $router.push({
                            name: 'CategoryCreate',
                        })
                "
            >
                Danh mục mới
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
import { getCategories } from '@/services/category';
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
                // { data: 'code', title: 'Mã danh mục', sortable: true },
                {
                    data: "name",
                    title: "Tên danh mục",
                    sortable: true,
                },
                {
                    data: "number_courses",
                    title: "Số khóa học",
                    sortable: true,
                },
            ];
        },
        setFilters() {
            this.filters = [
                {
                    data: "search",
                    type: "CFormInput",
                    label: "Tên Danh mục",
                },
            ];
        },
        setQueries() {
            this.queries = this.$route.query;
        },
        async handleGetData() {
            this.isLoading = true;
            this.pages = 1;

            try {
                const response = await getCategories(this.queries);
                if (response) {
                    this.datas = response.data.data;
                    this.pages = response.data.pagination.total_pages;
                }
            } finally {
                this.isLoading = false;
            }
        },
        handleView(event) {
            this.$router.push({
                name: "DeviceDetail",
                params: { categoryId: this.categoryId, deviceId: event.id },
            });
        },
        handleEdit(event) {
            this.$router.push({
                name: "CategoryEdit",
                params: { categoryId: event.id },
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
                if (this.$route.name === "CategoryList") {
                    this.setQueries();
                    await this.handleGetData();
                }
            }
        );
    },
};
</script>
