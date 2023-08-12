<template>
    <ContentCard>
        <template #title> Danh sách khóa học </template>

        <div class="d-flex justify-content-end mb-3">
            <CButton
                color="success"
                class="text-white"
                @click="
                    () =>
                        $router.push({
                            name: 'CourseCreate',
                        })
                "
            >
                Khóa học mới
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
import { getCourses } from "@/services/course";
import { getCategories } from "@/services/category";
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
            categoryData,
            toast,
        };
    },
    methods: {
        ...mapActions(["showDialog"]),
        setColumns() {
            this.columns = [
                // { data: 'code', title: 'Mã lớp', sortable: true },
                {
                    data: "name",
                    title: "Tên môn",
                    sortable: true,
                },
                {
                    data: "teacher_name",
                    title: "Giảng viên",
                    sortable: true,
                },
                {
                    data: "category",
                    title: "Danh mục",
                    sortable: true,
                },
                {
                    data: "number_parts",
                    title: "Số buổi",
                    sortable: true,
                },
                {
                    data: "number_enrolls",
                    title: "Số học sinh",
                    sortable: true,
                },
            ];
        },
        setFilters() {
            this.filters = [
                {
                    data: "search",
                    type: "CFormInput",
                    label: "Tên môn",
                },
                {
                    data: "teacher",
                    type: "CFormInput",
                    label: "Giảng viên",
                },
                {
                    data: "category",
                    type: 'CFormSelect',
                    label: "Danh mục",
                    options: this.categoryData,
                },
            ];
        },
        setQueries() {
            this.queries = this.$route.query;
        },
        async getCategoryInfo() {
            try {
                const response = await getCategories({itemsPerPage: 100});
                if (response) {
                    this.categoryData = response.data.data.map((e) => {
                        return {
                            id: e.id,
                            name: e.name,
                        };
                    });
                }

            } finally {
                this.isLoading = false;
            }

        },
        async handleGetData() {
            this.isLoading = true;
            this.pages = 1;

            // TODO: Call api to get data here
            try {
                const response = await getCourses(this.queries);
                this.datas = response.data.data;
                this.pages = response.data.pagination.total_pages;
            } finally {
                this.isLoading = false;
            }

        },
        handleView(event) {
            this.$router.push({
                name: "CourseDetail",
                params: { courseId: event.id },
            });
        },
        handleEdit(event) {
            this.$router.push({
                name: "CourseEdit",
                params: { courseId: event.id },
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
        await this.getCategoryInfo();
        this.setQueries();
        await this.handleGetData();
        this.setFilters();
        this.setColumns();

        // watch query change
        this.$watch(
            () => this.$route.query,
            async () => {
                if (this.$route.name === "CourseList") {
                    this.setQueries();
                    await this.handleGetData();
                }
            }
        );
    },
};
</script>
