<template>
    <ContentCard>
        <template #title>
            {{ courseId ? "Chỉnh sửa định hướng" : "Tạo định hướng" }}
        </template>

        <Form
            as="CForm"
            @submit="handleSubmit"
            :validation-schema="schema"
            v-slot="{ errors }"
        >
            <FormField
                type="CFormInput"
                name="name"
                label="Tên định hướng"
                required
                :value="data?.name"
                :error="errors.name"
            />

            <FormField
                type="CFormTextarea"
                name="description"
                label="Mô tả"
                alignLabel="top"
                textareaRows="3"
                :value="data?.description"
            />

            <CRow class="mb-3">
                <CCol sm="5" lg="4" xl="3" class="align-self-center">
                    <CFormLabel class="m-sm-0">
                        <h6>Điều kiện:</h6>
                    </CFormLabel>
                </CCol>
                <CCol sm="7" lg="8" xl="9"> </CCol>
            </CRow>

            <template v-if="parts.length > 0">
                <CCard v-for="(part, index) in parts" :key="part" class="mb-3">
                    <CCardHeader class="text-end">
                        <div class="align-items-center">
                            <!-- <h4 class="m-0 flex-grow-1">
                                    {{ part.label }}
                                </h4> -->
                            <CCloseButton @click="removePart(index)" />
                        </div>
                    </CCardHeader>
                    <CCardBody>
                        <FormField
                            type="CFormSelect"
                            :name="`parts[${index}].category`"
                            label="Danh mục"
                            :selectOptions="categoryOptions"
                            :error="errors.category"
                            :value="data?.category_id"
                            required
                        />

                        <FormField
                            type="CFormSelect"
                            :name="`parts[${index}].level`"
                            label="Độ khó"
                            :selectOptions="levelOptions"
                            :error="errors.level"
                            :value="data?.level"
                            required
                        />
                    </CCardBody>
                </CCard>
            </template>

            <div
                class="d-grid d-sm-flex gap-2 gap-sm-0 align-items-sm-center justify-content-sm-center"
            >
                <CButton
                    color="success"
                    class="ms-2 text-white"
                    @click="addPart()"
                >
                    Thêm điều kiện <font-awesome-icon icon="fa-solid fa-plus" />
                </CButton>
            </div>
            <!-- Buttons -->
            <div>
                <hr />

                <div
                    class="d-grid d-sm-flex gap-2 gap-sm-0 align-items-sm-center justify-content-sm-end"
                >
                    <CButton
                        type="submit"
                        color="primary"
                        class="text-white text-nowrap px-sm-5"
                        :disabled="isSubmiting || isLoading"
                    >
                        <CSpinner
                            v-if="isSubmiting"
                            component="span"
                            size="sm"
                            aria-hidden="true"
                        />
                        <span v-else>{{ $t("common.save") }}</span>
                    </CButton>

                    <CButton
                        @click="
                            () =>
                                $router.push({
                                    name: 'DeviceList',
                                })
                        "
                        color="light"
                        class="text-nowrap px-sm-5 ms-sm-3"
                        :disabled="isSubmiting || isLoading"
                    >
                        {{ $t("common.cancel") }}
                    </CButton>
                </div>
            </div>
        </Form>
    </ContentCard>
</template>

<script>
import ContentCard from "@/components/Common/ContentCard.vue";
import FormField from "@/components/Common/FormField.vue";
import { Form } from "vee-validate";
import { useRoute } from "vue-router";
import { ref } from "@vue/reactivity";
import * as yup from "yup";
import { getCategories } from "@/services/category";
import { createCourse, getCourseDetail } from "@/services/course";
import * as levels from "@/configs/course/level";
import { useToast } from "vue-toastification";

export default {
    components: {
        ContentCard,
        FormField,
        Form,
    },
    setup() {
        const courseId = useRoute().params.courseId;
        const categoryOptions = ref([]);
        const levelOptions = Object.values(levels)
            .sort((a, b) => a.id - b.id)
            .map((level) => ({
                name: level.name,
                value: level.id,
            }));
        const isLoading = ref(false);
        const isSubmiting = ref(false);
        const parts = ref([]);
        const data = ref({});
        const toast = useToast();

        return {
            courseId,
            categoryOptions,
            levelOptions,
            isLoading,
            isSubmiting,
            parts,
            data,
            toast,
        };
    },
    computed: {
        getPartInfo() {
            return (id) => this.parts[id] || {};
        },
    },
    methods: {
        async getCourseInfo() {
            this.isLoading = true;
            try {
                const response = await getCourseDetail(this.courseId);
                if (response) {
                    this.data = response.data;
                    this.parts = this.data.parts;
                    console.log(response);
                }
            } finally {
                this.isLoading = false;
            }
        },
        async handleGetData() {
            this.isLoading = true;
            try {
                const response = await getCategories();
                if (response) {
                    this.categoryOptions = response.data.map((e) => {
                        return {
                            value: e.id,
                            name: e.name,
                        };
                    });
                }
            } finally {
                this.isLoading = false;
            }
        },
        async handleSubmit(result) {
            this.isSubmiting = true;
            // try {
            //     let formData = new FormData();
            //     formData.append("name", result.name);
            //     formData.append("category", result.category);
            //     formData.append("level", result.level);
            //     formData.append("price", result.price);
            //     formData.append("teacher_id", 2);
            //     formData.append("description", result.description ?? null);
            //     formData.append("photo", result.image ?? null);
            //     formData.append(
            //         "parts",
            //         result.parts.map((e) => {
            //             return JSON.stringify(e);
            //         }) ?? null
            //     );

            //     if (!this.courseId) {
            //         const response = await createCourse(formData);
            //         if (response) {
            //             console.log(response);
            //             this.toast.success("Tạo khóa học mới thành công");
            //         }
            //     } else {
            //     }
            // } finally {
            //     this.isSubmiting = false;
            // }
            this.$router.push({
              name: "DirectionList",

            });
            this.toast.success("Tạo khóa học mới thành công");
        },
        addPart() {
            this.parts.push({
                // label: 'Buổi' + (this.parts.length+1),
                name: "",
                description: "",
                lectures: [],
            });
        },
        removePart(index) {
            this.parts.splice(index, 1);
            console.log(this.parts);
        },
    },
    async created() {
        await this.handleGetData();
        if (this.courseId) {
            await this.getCourseInfo(this.courseId);
        }
    },
};
</script>
