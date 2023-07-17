<template>
  <CRow class="mb-3">
    <CCol sm="5" lg="4" xl="3" :class="'align-self-' + alignLabel">
      <CFormLabel :for="name" class="m-sm-0">
        <h6>{{ label }}: <span v-if="required" class="text-danger">*</span></h6>
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
            <input type="file"
            @change="handleChange($event)"/>
          </template>
        </Field>
      </slot>
    </CCol>
  </CRow>
</template>

<script>
import { Field } from 'vee-validate'
import { ref } from '@vue/reactivity'

export default {
  name: 'FormField',
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
      default: '',
    },
    error: {
      type: String,
      required: false,
      default: '',
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
    alignLabel: {
      type: String,
      required: false,
      default: 'center',
    },
    inputType: {
      type: String,
      required: false,
      default: 'text',
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
  },
  components: {
    Field,
  },
  setup(props) {
    const attributes = ref({})
    const filledValue = ref(props.value)

    return {
      attributes,
      filledValue,
    }
  },
  methods: {
    // THIS MAY NOT WORK PROPERLY, CHECK THIS WHEN BUG HAPPENED
    addAttribute() {
      if (this.type === 'CFormInput') {
        this.attributes['type'] = this.inputType
      }

      if (this.type === 'CFormTextarea' || this.inputType === 'text') {
        this.attributes['minLength'] = this.minLength
        this.attributes['maxLength'] = this.maxLength
      }

      if (this.type === 'CFormTextarea') {
        this.attributes['rows'] = this.textareaRows
      }

      if (this.inputType === 'number') {
        this.attributes['min'] = this.min
        this.attributes['max'] = this.max
      }
    },
    handleChange(e) {
      // Check if file is selected
        if (e.target.files && e.target.files[0]) {
            // Get uploaded file
            const file = e.target.files[0]
            // Get file size
            // Get file name
            // Check if file is an image
            // Print to console
            const fileSize = Math.round((file.size / 1024 / 1024) * 100) / 100;
            // Get file extension
            const fileExtention = file.name.split(".").pop();
            // Get file name
            const fileName = file.name.split(".").shift();
            console.log(file.name);
            let reader = new FileReader();
        }
        
    }
  },
  created() {
    this.addAttribute()

    this.$watch(
      () => this.$props.value,
      (changedValue) => {
        this.filledValue = changedValue
      },
    )
  },
}
</script>
