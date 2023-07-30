<template>
    <div>
        <ContentCard>
            <template #title> Gợi ý khóa học </template>
            <Form
                as="CForm"
                @submitprevent="handleSubmit"
                :validation-schema="schema"
                v-slot="{ errors }"
            >
                <CRow class="align-items-center">
                    <CCol xs="10">
                        <FormField
                            type="select"
                            name="selectedCourse"
                            label="Chọn người dùng"
                            required
                        >
                            <template #field>
                                <Field
                                    name="selectedEmployee"
                                    v-slot="{ field }"
                                >
                                    <Multiselect
                                        ref="selected"
                                        v-model="student"
                                        v-bind="field"
                                        :options="getUsers"
                                        searchable
                                        mode="single"
                                        :filter-results="false"
                                        :minChars="0"
                                        :delay="500"
                                        :noOptionsText="$t('common.noData')"
                                        :noResultsText="$t('common.noData')"
                                        :class="[
                                            'form-control',
                                            !!errors.selectedEmployee
                                                ? 'is-invalid'
                                                : '',
                                        ]"
                                    />

                                    <div
                                        v-if="!!errors.selectedEmployee"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.selectedEmployee }}
                                    </div>
                                </Field>
                            </template>
                        </FormField>
                    </CCol>
                    <CCol xs="2">
                        <CButton
                            color="primary"
                            class="text-white text-nowrap px-sm-5"
                            @click="findSimilar"
                            :disabled="isSubmiting || isLoading"
                        >
                            <CSpinner
                                v-if="isSubmiting"
                                component="span"
                                size="sm"
                                aria-hidden="true"
                            />
                            <span v-else>{{ $t("common.confirm") }}</span>
                        </CButton>
                    </CCol>
                </CRow>
            </Form>
            <CTable>
                <CTableHead>
                    <CTableRow>
                        <CTableHeaderCell
                            v-for="column in columns"
                            :key="column.key"
                            class="text-nowrap"
                            >{{ column.label }}</CTableHeaderCell
                        >
                    </CTableRow>
                </CTableHead>

                <CTableBody>
                    <CTableRow
                        v-for="data in items"
                        :key="data.id"
                        class="align-middle"
                    >
                        <CTableDataCell
                            v-for="column in columns"
                            :key="column.key"
                        >
                            <div v-if="column.key != 'value'">
                                {{ data[column.key] }}
                            </div>
                            <div v-else>
                                <CProgress :height="20">
                                    <CProgressBar
                                        color="info"
                                        :value="data[column.key] * 100"
                                        >{{ data[column.key] }}</CProgressBar
                                    >
                                </CProgress>
                            </div>
                        </CTableDataCell>
                    </CTableRow>
                </CTableBody>
            </CTable>
        </ContentCard>
        <ContentCard class="mt-4">
            <template #title> Combine Weight </template>
            <Form
                as="CForm"
                @submit="handleSubmit"
                :validation-schema="schema"
                v-slot="{ errors }"
            >
                <CRow>
                    <CCol xs="10">
                        <FormField
                            v-model="config"
                            type="CFormInput"
                            name="config"
                            label="Giá trị"
                            required
                            max="1"
                            :value="config"
                        />
                    </CCol>
                    <CCol xs="2">
                        <CButton
                            color="primary"
                            class="text-white text-nowrap px-sm-5"
                            @click="changeConfig()"
                            :disabled="isSubmiting || isLoading"
                        >
                            <CSpinner
                                v-if="isSubmiting"
                                component="span"
                                size="sm"
                                aria-hidden="true"
                            />
                            <span v-else>{{ $t("common.confirm") }}</span>
                        </CButton>
                    </CCol>
                </CRow>
            </Form>
        </ContentCard>
        <!-- <ContentCard class="mt-4">
            <template #title> Score đăng ký </template>
            <DataTable
                :columns="enroll_columns"
                :datas="enroll_datas"
                :pages="enroll_pages"
                :isLoading="enroll_isLoading"
                :hideFilters="true"
                :hideActions="true"
                :hideItemPerPageSelector="true"
                :hideIndex="true"
            >
            </DataTable>
        </ContentCard> -->
        <!-- <ContentCard class="mt-4">
            <template #title> Ma trận </template>
             <apexchart
                type="heatmap"
                :options="chartOptions"
                :series="series"
            ></apexchart>   
        </ContentCard> -->
    </div>
</template>
<script>
import ContentCard from "@/components/Common/ContentCard.vue";
import FormField from "@/components/Common/FormField.vue";
import DetailField from "@/components/Common/DetailField.vue";
import DataTable from "@/components/Common/DataTable.vue";
import { ref } from "@vue/reactivity";
import { Form, Field } from "vee-validate";
import { useToast } from "vue-toastification";
import * as yup from "yup";
import VueApexCharts from "vue3-apexcharts";
import json from "./similar.json";
import { searchStudent } from "../../services/user";
import { recomend } from "../../services/recomend";

export default {
    components: {
        ContentCard,
        FormField,
        DetailField,
        Form,
        Field,
        apexchart: VueApexCharts,
        DataTable,
    },
    setup() {
        const datas = json;
        const chartOptions = {
            chart: {
                height: 350,
                type: "heatmap",
            },
            dataLabels: {
                enabled: true,
            },
            colors: ["#008FFB"],
            title: {},
        };
        const series = [];
        const columns = [];
        const items = ref([]);
        const student = ref();
        const enroll_columns = ref([]);
        const enroll_datas = ref([]);
        const enroll_pages = ref(1);
        const enroll_isLoading = ref(false);
        const config = ref(0.5);
        return {
            datas,
            chartOptions,
            series,
            columns,
            items,
            student,
            enroll_columns,
            enroll_datas,
            enroll_pages,
            enroll_isLoading,
            config,
        };
    },
    methods: {
        setSchema() {
            this.schema = yup.object({
                selectedEmployee: yup
                    .string()
                    .nullable()
                    .required(this.$t("validate.common.required")),
            });
        },
        async getUsers(keyword = "") {
            // TODO: put api here to get users by keyword, at most 10 users
            console.log("Get users by keyword", keyword);
            try {
                const response = await searchStudent({ search: keyword });
                return response.data;
            } catch (error) {
                console.error(error);
                return [];
            }
        },
        async findSimilar() {
            console.log(this.student);
            try {
                const response = await recomend(this.student);
                this.items = response.data.slice(0, 5);
                console.log(this.items);
            } catch (error) {
                console.error(error);
            }
            // var result = Object.keys(this.datas[this.course]).map((key) => [key-1, this.datas[this.course][key]]);
            // let sort = result.sort((a,b) => b[1] - a[1] )
            // let select = sort.slice(1,6);
            // console.log(select)
            // select.forEach((a, index) => {
            //     this.items.push({
            //         id: index+1,
            //         class: this.courses[a[0]],
            //         score: a[1]
            //     })
            // })
        },
        changeConfig() {},
    },
    created() {
        this.courses = [
            "Thiết kế giao diện người dùng",
            "Kiểm thử và đảm bảo chất lượng phần mềm",
            "Kiến trúc phần mềm",
            "Phân tích và thiết kế hướng đối tượng",
            "Quản lý dự án phần mềm",
            "Giải tích",
            "Tư duy toán học",
            "Đại số tuyến tính",
            "Lý thuyết trò chơi",
            "Trí tuệ nhân tạo",
            "Chương trình dịch",
            "Xử lý ảnh",
            "Xử lý ngôn ngữ tự nhiên",
            "Nhập môn tiếng Nhật",
            "Tiếng Anh giao tiếp",
            "Lập trình mạng",
            "Phát triển ứng dụng Web",
            "An ninh mạng",
            "Kinh tế tiền tệ và ngân hàng",
            "Nguyên tắc kinh tế vi mô",
            "Khái niệm cơ bản về giao dịch",
            "Cơ sở kinh doanh",
            "Thị trường tài chính",
            "Giới thiệu về marketing",
            "Marketing trong thế giới thực",
            "Tiếp thị kỹ thuật số",
            "Lịch sử Việt Nam cận đại",
            "Chiến tranh thế giới thứ 1",
            "Chiến tranh thế giới thứ 2",
            "Văn hóa Việt Nam",
            "Lịch sử Hà Nội",
            "Dinh dưỡng cho trẻ",
            "Tâm lý xã hội",
            "Bệnh tiểu đường",
            "Giới thiệu về kiến trúc",
            "Nhạc truyền thống",
            "Hội họa",
        ];
        this.courses.forEach((value, index) => {
            var result = Object.keys(this.datas[index]).map((key) => [
                key - 1,
                this.datas[index][key],
            ]);
            let data_simi = [];
            result.forEach((score, index1) => {
                data_simi.push({
                    x: this.courses[index1],
                    y: score[1].toFixed(2),
                });
            });
            this.series.push({
                name: value,
                data: data_simi,
            });
        });
        this.columns = [
            {
                key: "id",
                label: "#",
                _props: { scope: "col" },
            },
            {
                key: "course",
                label: "Tên môn",
                _props: { scope: "col" },
            },
            {
                key: "value",
                label: "Score gợi ý",
                _props: { scope: "col" },
            },
        ];

        this.enroll_columns = [
            { data: "id", title: "Id", sortable: false },
            {
                data: "name",
                title: "Học viên",
                sortable: false,
            },
            {
                data: "course",
                title: "Tên môn",
                sortable: false,
            },
            {
                data: "num_of_part",
                title: "Số buổi",
                sortable: false,
            },
            {
                data: "num_of_student",
                title: "Số học sinh",
                sortable: false,
            },
        ];
        this.enroll_datas = [
            {
                id: 1,
                name: "user1",
                course: "Nguyễn Văn Mạnh",
                num_of_part: 50,
                num_of_student: 50,
            },
        ];
    },
};
</script>
