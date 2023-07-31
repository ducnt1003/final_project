<template>
    <div>
        <CRow>
            <template v-for="(page, index) in pages" :key="index">
                <CCol :sm="6" :lg="4" :xl="3" class="mb-3">
                    <template v-if="!isLoading">
                        <DashboardLinkCard
                            :title="page.title"
                            :pathName="page.pathName"
                            :icon="page.icon"
                            :quantity="page.quantity"
                        />
                    </template>
                    <template v-else>
                        <CCard>
                            <CCardBody>
                                <Loading />
                            </CCardBody>
                        </CCard>
                    </template>
                </CCol>
            </template>
        </CRow>
        <CRow>
            <CCol :sm="6" class="mb-3">
                <CCard>
                    <CCardBody>
                        <CChart
                            type="bar"
                            :data="data_courses"
                            :options="{
                                indexAxis: 'y',
                                elements: {
                                    bar: {
                                        borderWidth: 2,
                                    },
                                },
                                responsive: true,
                            }"
                        />
                    </CCardBody>
                </CCard>
            </CCol>
            <CCol :sm="6" class="mb-3">
                <CCard>
                    <CCardBody>
                        <CChart
                            type="bar"
                            :data="data_users"
                            :options="{
                                indexAxis: 'y',
                                elements: {
                                    bar: {
                                        borderWidth: 2,
                                    },
                                },
                                responsive: true,
                            }"
                        />
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
    </div>
</template>
<script>
import DashboardLinkCard from "../components/Dashboards/DashboardLinkCard.vue";
import { CChart } from "@coreui/vue-chartjs";
export default {
    name: "Dashboard",
    components: {
        DashboardLinkCard,
        CChart,
    },
    data() {
        return {
            pages: [
                {
                    title: "Bài giảng",
                    pathName: "User",
                    icon: "fa-book",
                    quantity: 46,
                },
                {
                    title: "Đăng ký",
                    pathName: "User",
                    icon: "fa-person-chalkboard",
                    quantity: 2037,
                },
                {
                    title: "Danh mục",
                    pathName: "User",
                    icon: "fa-archive",
                    quantity: 16,
                },
                {
                    title: "Học viên",
                    pathName: "User",
                    icon: "fa-user",
                    quantity: 1417,
                },
            ],
            data_courses: {
                labels: [
                    "Thiết kế giao diện người dùng",
                    "Kiểm thử và đảm bảo chất lượng phần mềm",
                    "Kiến trúc phần mềm",
                    "Quản lý dự án phần mềm",
                    "Đại số tuyến tính",
                    "Lý thuyết trò chơi",
                ],
                datasets: [
                    {
                        label: "Số người đăng ký",
                        backgroundColor: "#768db9",
                        data: [120, 104, 98, 87, 73, 62],
                    },
                ],
            },
            data_users: {
                labels: [
                    "Thang Nguyen",
                    "Duc Nguyen",
                    "Trung Pham",
                    "Manh Nguyen",
                    "Hai Pham",
                    "Huong Pham",
                ],
                datasets: [
                    {
                        label: "Số người đăng ký nhiều nhất",
                        backgroundColor: "#404c64",
                        data: [21,17,17,13,9,7],
                    },
                ],
            },
        };
    },
};
</script>
