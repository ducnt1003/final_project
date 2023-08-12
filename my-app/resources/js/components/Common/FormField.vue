<template>
    <div>
        <CRow class="mb-3">
            <CCol sm="5" lg="4" xl="3" :class="'align-self-' + alignLabel">
                <CFormLabel :for="name" class="m-sm-0">
                    <h6>
                        {{ label }}:
                        <span v-if="required" class="text-danger">*</span>
                    </h6>
                </CFormLabel>
            </CCol>
            <CCol sm="7" lg="8" xl="9">
                <slot name="field">
                    <Field
                        v-model="filledValue"
                        :as="type"
                        :name="name"
                        :id="id || name"
                        :placeholder="placeholder"
                        :disabled="disabled"
                        :invalid="!!error"
                        :feedback-invalid="error"
                        v-bind="attributes"
                    >
                        <template v-if="type === 'CFormSelect'">
                            <option value=""></option>
                            <option
                                v-for="option in selectOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.name }}
                            </option>
                        </template>
                        <template v-if="type === 'CFormType'">
                            <input type="file" @change="handleChange($event)" />
                        </template>
                    </Field>
                </slot>
            </CCol>
        </CRow>
        <CRow class="mb-3">
            <CCol sm="5" lg="4" xl="3"></CCol>
            <CCol sm="7" lg="8" xl="9">
                <img v-if="image" :src="image" width="300" />
                <img v-if="image_url && !image" :src="image_url" width="300" />
                <object
                    v-if="type_url == 'pdf' && !object_type"
                    :data="url"
                    type="application/pdf"
                    width="300"

                ></object>

                <video v-if="type_url == 'mp4' && !object_type" width="300" controls>
                    <source :src="url" type="video/mp4" />
                </video>
                <object
                    v-if="object_type == 'pdf'"
                    :data="object"
                    type="application/pdf"
                    width="300"

                ></object>

                <video v-if="object_type == 'mp4'" width="300" controls>
                    <source :src="object" type="video/mp4" />
                </video>
            </CCol>
        </CRow>
    </div>
</template>

<script>
import { Field } from "vee-validate";
import { ref } from "@vue/reactivity";

export default {
    name: "FormField",
    props: {
        type: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        value: {
            type: [String, Number, Object, Array],
            required: false,
        },
        id: {
            type: String,
            required: false,
        },
        required: {
            type: Boolean,
            required: false,
            deafult: false,
        },
        placeholder: {
            type: String,
            required: false,
            default: "",
        },
        error: {
            type: String,
            required: false,
            default: "",
        },
        disabled: {
            type: Boolean,
            required: false,
            default: false,
        },
        alignLabel: {
            type: String,
            required: false,
            default: "center",
        },
        inputType: {
            type: String,
            required: false,
            default: "text",
        },
        maxLength: {
            type: [Number, String],
            required: false,
        },
        minLength: {
            type: [Number, String],
            required: false,
        },
        max: {
            type: [Number, String],
            required: false,
        },
        min: {
            type: [Number, String],
            required: false,
        },
        selectOptions: {
            type: Array,
            required: false,
            default: () => [],
        },
        textareaRows: {
            type: [Number, String],
            required: false,
            default: 3,
        },
        image_url: {
            type: String,
            required: false,
        },
        url: {
            type: String,
            required: false,
        },
        type_url: {
            type: String,
            required: false,
        },
    },
    components: {
        Field,
    },
    setup(props) {
        const attributes = ref({});
        const filledValue = ref(props.value);
        const image = ref();
        const object = ref();
        const object_type = ref();

        return {
            attributes,
            filledValue,
            image,
            object,
            object_type
        };
    },
    methods: {
        // THIS MAY NOT WORK PROPERLY, CHECK THIS WHEN BUG HAPPENED
        addAttribute() {
            if (this.type === "CFormInput") {
                this.attributes["type"] = this.inputType;
            }

            if (this.type === "CFormTextarea" || this.inputType === "text") {
                this.attributes["minLength"] = this.minLength;
                this.attributes["maxLength"] = this.maxLength;
            }

            if (this.type === "CFormTextarea") {
                this.attributes["rows"] = this.textareaRows;
            }

            if (this.inputType === "number") {
                this.attributes["min"] = this.min;
                this.attributes["max"] = this.max;
            }
        },
        handleChange(e) {
            // Check if file is selected
            if (e.target.files && e.target.files[0]) {
                // Get uploaded file
                const file = e.target.files[0];
                // Get file size
                // Get file name
                // Check if file is an image
                // Print to console
                const fileSize =
                    Math.round((file.size / 1024 / 1024) * 100) / 100;
                // Get file extension
                const fileExtention = file.name.split(".").pop();
                // Get file name
                const fileName = file.name.split(".").shift();
                if (fileExtention == 'mp4' || fileExtention == 'pdf') {
                    this.object = URL.createObjectURL(file);
                    this.object_type = fileExtention
                } else {
                    this.image = URL.createObjectURL(file);
                }
            }
        },
    },
    created() {
        this.addAttribute();

        this.$watch(
            () => this.$props.value,
            (changedValue) => {
                this.filledValue = changedValue;
            }
        );
    },
};
</script>
