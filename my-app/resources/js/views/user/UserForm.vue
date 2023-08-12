<template>
    <ContentCard>
        <template #title>
            {{ userId ? "Chỉnh sửa người dùng" : "Tạo người dùng" }}
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
                label="Tên"
                required
                :value="data?.name"
                :error="errors.name"
            />

            <FormField
                type="CFormInput"
                name="email"
                label="Email"
                required
                :value="data?.email"
                :error="errors.email"
            />

            <FormField
                type="CFormInput"
                name="phone"
                label="Số điện thoại"
                required
                :value="data?.phone"
                :error="errors.phone"
            />

            <FormField
                type="CFormSelect"
                name="role_id"
                label="Vai trò"
                :selectOptions="roleOptions"
                :error="errors.category"
                :value="data?.role_id"
                required
            />

            <FormField
                type="CFormInput"
                name="school"
                label="Trường"
                required
                :value="data?.school"
                :error="errors.school"
            />

            <FormField
                v-if="!userId"
                type="CFormInput"
                name="password"
                label="Mật khẩu"
                required
            />


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
                                    name: 'CategoryList',
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
import { getCategory, createCategory, editCategory } from "@/services/category";
import { useToast } from "vue-toastification";

export default {
    components: {
        ContentCard,
        FormField,
        Form,
    },
    setup() {
        const userId = useRoute().params.userId;

        const isLoading = ref(false);
        const isSubmiting = ref(false);
        const data = ref({});
        const toast = useToast();
        const roleOptions = [
            {
                name: 'Student',
                value: 0
            },
            {
                name: 'Teacher',
                value: 1
            },
            {
                name: 'Admin',
                value: 2
            },
            {
                name: 'Expert',
                value: 3
            },
        ]

        return {
            userId,
            isLoading,
            isSubmiting,
            data,
            toast,
            roleOptions
        };
    },
    computed: {

    },
    methods: {
        async handleGetData() {
            this.isLoading = true;
            // try {
            //     const response = await getCategory(this.categoryId);
            //     if (response) {
            //         this.data = response.data
            //     }
            // } finally {
            //     this.isLoading = false;
            // }
        },
        async handleSubmit(result) {
            this.isSubmiting = true;
            try {
                let formData = new FormData();
                formData.append("name", result.name);
                formData.append("description", result.description ?? null);

                console.log(formData);
                if (!this.categoryId) {
                    const response = await createCategory(formData);
                    if (response) {
                        console.log(response);
                        this.$router.push({
                            name: "CategoryList",
                        });
                        this.toast.success("Tạo danh mục mới thành công");
                    }
                } else {
                    const response = await editCategory(formData);
                    if (response) {
                        console.log(response);
                        this.$router.push({
                            name: "CategoryList",
                        });
                        this.toast.success("Chỉnh sửa định hướng mới thành công");
                    }
                }
            } finally {
                this.isSubmiting = false;
            }

        },
    },
    async created() {
        await this.handleGetData()
    },
};
</script>
