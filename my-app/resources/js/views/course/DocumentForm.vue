<template>
    <ContentCard>
        <template #title> Upload tài liệu </template>
        <div>
            <DetailField label="Môn học" :value="data?.name" />
            <DetailField label="Buổi" :value="part?.part" />
            <DetailField label="Tên buổi" :value="part?.name" />
        </div>

        <Form
            as="CForm"
            @submit="handleSubmit"
            :validation-schema="schema"
            v-slot="{ errors }"
        >
            <template v-if="documents.length > 0">
                <CCard
                    v-for="(document, index) in documents"
                    :key="document"
                    class="mb-3"
                >
                    <CCardHeader class="text-end">
                        <div class="align-items-center">
                            <!-- <h4 class="m-0 flex-grow-1">
                                {{ part.label }}
                            </h4> -->
                            <CCloseButton @click="removeDocument(index)" />
                        </div>
                    </CCardHeader>
                    <CCardBody>
                        <!-- <HiddenField :name="`parts[${index}].id`" /> -->

                        <Field
                            as="hidden"
                            :name="`documents[${index}].id`"
                            :value="getDocumentInfo(index).id"
                        />
                        <FormField
                            type="CFormInput"
                            :name="`documents[${index}].name`"
                            :value="getDocumentInfo(index).name"
                            :label="$t('common.name')"
                            :error="errors?.[`documents[${index}].name`]"
                            required
                        />
                        <FormField
                            type="CFormTextarea"
                            :name="`documents[${index}].description`"
                            :value="getDocumentInfo(index).description"
                            alignLabel="top"
                            textareaRows="3"
                            :label="$t('common.description')"
                            :error="errors?.[`documents[${index}].description`]"
                        />
                        <FormField
                            type="CFormType"
                            :name="`documents[${index}].path`"
                            label="Tài liệu"
                            alignLabel="top"
                            textareaRows="3"
                            required
                            :url="getDocumentInfo(index).path"
                            :type_url="getDocumentInfo(index).type"
                        />
                    </CCardBody>
                </CCard>
                <div
                    class="d-grid d-sm-flex gap-2 gap-sm-0 align-items-sm-center justify-content-sm-center"
                >
                    <CButton
                        color="success"
                        class="ms-2 text-white"
                        @click="addDocument()"
                    >
                        Thêm bài giảng
                        <font-awesome-icon icon="fa-solid fa-plus" />
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
                                        name: 'CourseList',
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
            </template>
        </Form>
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
        const partId = useRoute().params.partId;
        const data = ref({});
        const part = ref({});
        const documents = ref([]);
        return {
            courseId,
            data,
            partId,
            part,
            documents,
        };
    },
    computed: {
        getDocumentInfo() {
            return (id) => this.documents[id] || {};
        },
    },
    methods: {
        async getCourseInfo(courseId) {
            this.isLoading = true;
            try {
                const response = await getCourseDetail(courseId);
                if (response) {
                    this.data = response.data;
                    this.part = this.data.parts.find((e) => {
                        return e.id == this.partId;
                    });
                    this.documents = this.part.documents;
                }
            } finally {
                this.isLoading = false;
            }
        },
        addDocument() {
            this.documents.push({
                // label: 'Buổi' + (this.parts.length+1),
                name: "",
                description: "",
            });
        },
        removeDocument(index) {
            this.documents.splice(index, 1);
            console.log(this.parts);
        },
        async handleSubmit(result) {
            try {
                // console.log(result.image);
                let formData = new FormData();
                formData.append("name", result.name);
                formData.append("category", result.category);
                formData.append("level", result.level);
                formData.append("price", result.price);
                formData.append("teacher_id", 2);
                formData.append("description", result.description ?? null);
                formData.append("photo", result.image ?? null);
                if (result.parts) {
                    formData.append(
                        "parts",
                        result.parts.map((e) => {
                            return JSON.stringify(e);
                        }) ?? null
                    );
                }
                const response = await uploadDocument(this.partId, formData);
            } finally {
                this.isSubmiting = false;
            }

            console.log(result);
        },
    },
    async created() {
        await this.getCourseInfo(this.courseId);
    },
};
</script>
