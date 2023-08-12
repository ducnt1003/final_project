<template>
    <ContentCard>
        <template #title> Chi tiết khóa học </template>
        <div>
            <DetailField label="Môn học" :value="data?.name" />
            <DetailField label="Danh mục" :value="data?.category" />
            <DetailField label="Giáo viên" :value="data?.teacher_name" />
            <DetailField label="Độ khó" :value="data?.level_name" />
            <DetailField label="Mô tả" :value="data?.description" />
            <CRow class="mb-3">
                <CCol sm="5" lg="4" xl="3">
                    <CFormLabel :for="name" class="m-sm-0">
                        <h6>
                            Ảnh:
                        </h6>
                    </CFormLabel>
                </CCol>
                <CCol sm="7" lg="8" xl="9">
                    <img :src="data?.image" width="300" />

                </CCol>
            </CRow>
            <DetailField label="Buổi học" />

            <template v-if="parts.length > 0">
                <CCard v-for="(part, index) in parts" :key="part" class="mb-3">
                    <CCardHeader >
                        <div class="align-items-center">
                            <h4 class="m-0 flex-grow-1">
                                    Buổi {{ part.part }}
                                </h4>

                        </div>
                    </CCardHeader>
                    <CCardBody>
                        <!-- <HiddenField :name="`parts[${index}].id`" /> -->
                        <Field as="hidden" :name="`parts[${index}].id`" :value="getPartInfo(index).id" />
                        <DetailField :label="$t('common.name')" :value="getPartInfo(index).name" />
                        <DetailField :label="$t('common.description')" :value="getPartInfo(index).description" />
                        <div
                            class="d-grid d-sm-flex gap-2 gap-sm-0 align-items-sm-center justify-content-sm-end"
                        >
                            <CButton
                                color="info"
                                class="ms-2 text-white"
                                @click="upload(getPartInfo(index).id)"
                            >
                                Chỉnh sửa tài liệu
                            </CButton>
                        </div>
                    </CCardBody>
                </CCard>
            </template>

        </div>

    </ContentCard>
</template>

<script>
import ContentCard from "@/components/Common/ContentCard.vue";
import DetailField from "@/components/Common/DetailField.vue";
import { useRoute } from "vue-router";
import { ref } from "@vue/reactivity";
import { getCourseDetail } from "@/services/course";
import FormField from "@/components/Common/FormField.vue";
import { Form } from "vee-validate";
import { Field } from "vee-validate";

export default {
    components: {
        ContentCard,
        DetailField,
        FormField,
        Form,
        Field,
    },
    setup() {
        const courseId = useRoute().params.courseId;
        const data = ref({});
        const parts = ref([]);
        return {
            courseId,
            data,
            parts,
        };
    },
    computed: {
        getPartInfo() {
            return (id) => this.parts[id] || {};
        },
    },
    methods: {
        async getCourseInfo(courseId) {
            this.isLoading = true;
            try {
                const response = await getCourseDetail(courseId);
                if (response) {
                    this.data = response.data;
                   this.parts = this.data.parts
                }
            } finally {
                this.isLoading = false;
            }
        },
        upload(id) {
            this.$router.push({name: "CourseUpload", params:{courseId: this.courseId, partId : id}})
        }
    },
    async created() {
        await this.getCourseInfo(this.courseId);
    },
};
</script>
