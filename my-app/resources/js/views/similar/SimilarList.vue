<template>
    <div>
        <ContentCard>
            <template #title>
                Khóa học tương tự
            </template>
            <Form as="CForm" @submitprevent="handleSubmit" :validation-schema="schema" v-slot="{ errors }">
                <FormField type="select" name="selectedCourse" label="Chọn khóa học" required>
                    <template #field>
                        <CRow class="align-items-center">
                            <CCol xs="8">
                                <Field name="selectedEmployee" v-slot="{ field }">
                                    <Multiselect ref="selected"
                                        v-model="course" v-bind="field" :options="getUsers" searchable mode="single"
                                        :filter-results="false" :minChars="0" :delay="500"
                                        :noOptionsText="$t('common.noData')" :noResultsText="$t('common.noData')" :class="[
                                            'form-control',
                                            !!errors.selectedEmployee ? 'is-invalid' : '',
                                        ]" />

                                    <div v-if="!!errors.selectedEmployee" class="invalid-feedback">
                                        {{ errors.selectedEmployee }}
                                    </div>
                                </Field>
                            </CCol>
                            <CCol xs="2">
                                <CButton color="primary" class="text-white text-nowrap px-sm-5"
                                    @click="findSimilar"
                                    :disabled="isSubmiting || isLoading">
                                    <CSpinner v-if="isSubmiting" component="span" size="sm" aria-hidden="true" />
                                    <span v-else>{{ $t('common.confirm') }}</span>
                                </CButton>
                            </CCol>
                        </CRow>


                    </template>

                </FormField>
            </Form>
            <CTable :columns="columns" :items="items" />

        </ContentCard>
        <ContentCard class="mt-4">
            <template #title>
                Ma trận
            </template>
            <apexchart type="heatmap" :options="chartOptions" :series="series"></apexchart>
        </ContentCard>
    </div>
</template>
<script>
import ContentCard from '@/components/Common/ContentCard.vue'
import FormField from '@/components/Common/FormField.vue'
import DetailField from '@/components/Common/DetailField.vue'
import { ref } from '@vue/reactivity'
import { Form, Field } from 'vee-validate'
import { useToast } from 'vue-toastification'
import * as yup from 'yup'
import VueApexCharts from "vue3-apexcharts"
import json from './similar.json'

export default {
    components: {
        ContentCard,
        FormField,
        DetailField,
        Form,
        Field,
        apexchart: VueApexCharts,

    },
    setup() {
        const datas = json
        const chartOptions = {
            chart: {
                height: 350,
                type: 'heatmap',
            },
            dataLabels: {
                enabled: true
            },
            colors: ["#008FFB"],
            title: {

            },
        }
        const series = [];
        const columns = [];
        const items = ref([]);
        const course = ref();
        return {
            datas,
            chartOptions,
            series,
            columns,
            items,
            course
        }
    },
    methods: {
        setSchema() {
            this.schema = yup.object({
                selectedEmployee: yup
                    .string()
                    .nullable()
                    .required(this.$t('validate.common.required')),
            })
        },
        async getUsers(keyword = '') {
            // TODO: put api here to get users by keyword, at most 10 users
            console.log('Get users by keyword', keyword)
            try {
                await new Promise((resolve) => {
                    setTimeout(() => {
                        resolve()
                    }, 500)
                });
                let selectOptions = [];
                this.courses.forEach((value, index) => {
                    selectOptions.push({
                        value: index,
                        label: value
                    })
                });

                return selectOptions
            } catch (error) {
                console.error(error)
                return []
            }
        },
        findSimilar() {
            var result = Object.keys(this.datas[this.course]).map((key) => [key-1, this.datas[this.course][key]]);
            let sort = result.sort((a,b) => b[1] - a[1] )
            let select = sort.slice(1,6);
            console.log(select)
            select.forEach((a, index) => {
                this.items.push({
                    id: index+1,
                    class: this.courses[a[0]],
                    score: a[1]
                })
            })

        }
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
            "Hội họa"
        ]
        this.courses.forEach((value, index) => {
            var result = Object.keys(this.datas[index]).map((key) => [key-1, this.datas[index][key]]);
            let data_simi = [];
            result.forEach((score, index1) => {
                data_simi.push({
                    x: this.courses[index1],
                    y: score[1].toFixed(2)
                })

            })
            this.series.push({
                name:value,
                data: data_simi
            })
        })
        this.columns = [
                {
                    key: 'id',
                    label: '#',
                    _props: { scope: 'col' },
                },
                {
                    key: 'class',
                    label: 'Tên môn',
                    _props: { scope: 'col' },
                },
                {
                    key: 'score',
                    label: 'Tương đồng',
                    _props: { scope: 'col' },
                },
            ]

    }
}
</script>

