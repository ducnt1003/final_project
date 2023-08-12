<template>
    <ContentCard>
        <template #title> Chi tiết định hướng </template>
        <div>
            <DetailField label="Tên" :value="data?.name" />
            <DetailField label="Mô tả" :value="data?.description" />


            <template v-if="parts.length > 0">
                <CCard v-for="(part, index) in parts" :key="part" class="mb-3">
                    <CCardHeader >

                    </CCardHeader>
                    <CCardBody>
                        <!-- <HiddenField :name="`parts[${index}].id`" /> -->
                        <Field as="hidden" :name="`parts[${index}].id`" :value="getPartInfo(index).id" />
                        <DetailField label="Danh mục" :value="displayCate(getPartInfo(index).category_id).name" />
                        <DetailField label="Độ khó" :value="displayLevel(getPartInfo(index).level).name" />
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
import { getDirectionDetail } from "@/services/direction";
import FormField from "@/components/Common/FormField.vue";
import { Form } from "vee-validate";
import { Field } from "vee-validate";
import { getCategories } from "@/services/category";
import * as levels from "@/configs/course/level";


export default {
    components: {
        ContentCard,
        DetailField,
        FormField,
        Form,
        Field,
    },
    setup() {
        const directionId = useRoute().params.directionId;
        const data = ref({});
        const parts = ref([]);
        const categoryOptions = ref([])
        const levelOptions = Object.values(levels)
            .sort((a, b) => a.id - b.id)
            .map((level) => ({
                name: level.name,
                value: level.id,
            }));
        return {
            directionId,
            data,
            parts,
            categoryOptions,
            levelOptions
        };
    },
    computed: {
        getPartInfo() {
            return (id) => this.parts[id] || {};
        },
        displayCate(){
            return (id) => this.categoryOptions.find((e) => {return e.value == id}) || {}
        },
        displayLevel(id){
            return (id) => this.levelOptions.find((e) => {return e.value == id}) || {}
        },

    },
    methods: {
        async getDirectionInfo(directionId) {
            this.isLoading = true;
            try {
                const response = await getDirectionDetail(directionId);
                if (response) {
                    this.data = response.data;
                   this.parts = this.data.rules
                }
            } finally {
                this.isLoading = false;
            }
        },
        async getCate() {
            try {
                const response = await getCategories({itemsPerPage: 100});
                if (response) {
                    this.categoryOptions = response.data.data.map((e) => {
                        return {
                            value: e.id,
                            name: e.name,
                        };
                    });
                }
            } finally {
                this.isLoading = false;
            }
        }
    },
    async created() {
        if (this.directionId) {
            await this.getDirectionInfo(this.directionId);
            await this.getCate()
        }
    },
};
</script>
