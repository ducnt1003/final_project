<template>
  <Modal
      ref="modal"
      size="lg"
      backdrop="static"
      :keyboard="false"
      :displayCloseButton="false"
  >
    <template #title>
      {{
        categoryId
            ? $t('devices.editCategory.title')
            : $t('devices.addCategory.title')
      }}
    </template>

    <template v-if="!isLoading">
      <Form
          as="CForm"
          id="modalForm"
          ref="formRef"
          @submit="handleSendForm"
          v-slot="{ errors }"
          :validation-schema="schema"
      >
        <!-- Category Name -->
        <CRow class="mb-3">
          <CFormLabel
              for="name"
              class="col-sm-4 col-lg-3 col-form-label fw-bold"
          >
            {{ $t('devices.common.categoryName') }}:
          </CFormLabel>

          <CCol sm="8" lg="9">
            <Field
                as="CFormInput"
                name="name"
                id="name"
                v-model="data.name"
                :invalid="!!errors?.name"
                :feedback-invalid="errors?.name"
            />
          </CCol>
        </CRow>

        <!-- Property List -->
        <CRow class="mb-3">
          <CFormLabel
              for="property"
              class="col-sm-4 col-lg-3 col-form-label fw-bold"
          >
            {{ $t('devices.common.displayedProperties') }}:
          </CFormLabel>

          <CCol sm="8" lg="9">
            <Field v-model="data.properties" name="properties">
              <div
                  v-for="(property, index) in data.properties"
                  :key="property"
                  class="d-flex align-items-center mb-3"
              >
                <div class="flex-grow-1 ps-0 ps-sm-1">
                  {{ property.name }}
                </div>
                <div>
                  <CButton
                      color="light"
                      shape="rounded-pill"
                      class="ms-2"
                      @click="handleRemoveProperty(index)"
                  >
                    <CIcon icon="cil-x-circle" />
                  </CButton>
                </div>
              </div>
            </Field>

            <!-- New Property Input -->
            <CInputGroup>
              <CFormInput
                  name="property"
                  id="property"
                  :placeholder="$t('devices.common.addProperty')"
                  v-model="properyInput"
                  :invalid="!!errors?.properties"
              />
              <CButton
                  type="button"
                  color="secondary"
                  variant="outline"
                  class="text-dark"
                  @click="handleAddProperty"
              >
                <CIcon icon="cil-plus" />
              </CButton>
            </CInputGroup>

            <div class="d-block invalid-feedback">
              {{ errors?.properties }}
            </div>
          </CCol>
        </CRow>
      </Form>
    </template>

    <template v-else>
      <div class="d-flex align-items-center justify-content-center">
        <CSpinner color="primary" class="me-2" />
        <span>{{ $t('common.loading') }}</span>
      </div>
    </template>

    <template #footer>
      <div
          class="flex-grow-1 d-grid d-sm-flex gap-2 gap-sm-0 align-items-sm-center justify-content-sm-evenly"
      >
        <CButton
            type="submit"
            form="modalForm"
            color="primary"
            class="text-nowrap px-sm-5"
            :disabled="isSubmiting"
        >
          <CSpinner
              v-if="isSubmiting"
              component="span"
              size="sm"
              aria-hidden="true"
          />
          <span v-else>{{ $t('common.save') }}</span>
        </CButton>

        <CButton
            @click="handleCloseModal"
            color="secondary"
            class="text-white text-nowrap px-sm-5"
            :disabled="isSubmiting"
        >
          {{ $t('common.cancel') }}
        </CButton>
      </div>
    </template>
  </Modal>
</template>

<script>
import Modal from '@/components/Common/ModalLayout.vue'
import { Form, Field } from 'vee-validate'
import { EmptyOrWhiteSpace } from '@/configs/RegEx'
import { ref } from '@vue/reactivity'
import * as yup from 'yup'
// import { getCategoryDetail, createCategory, editCategory } from '@/services/category'
import { useToast } from 'vue-toastification'
import {toRaw} from 'vue'

export default {
  name: 'CategoryFormModal',
  components: {
    Modal,
    Form,
    Field,
  },
  setup() {
    const schema = ref({})

    const modal = ref(null)
    const formRef = ref(null)
    const isLoading = ref(false)
    const categoryId = ref(null)
    const isSubmiting = ref(false)

    const data = ref({
      name: '',
      properties: [],
    })
    const properyInput = ref('')
    const toast = useToast()

    return {
      schema,
      modal,
      formRef,
      isLoading,
      categoryId,
      isSubmiting,
      data,
      properyInput,
      toast
    }
  },
  methods: {
    createFormSchema() {
      this.schema = yup.object({
        name: yup.string().required(this.$t('validate.common.required')),
      })
    },
    openModal(id = null) {
      this.categoryId = id
      this.modal.openModal()

      if (id) {
        this.handleGetData(id)
      }
    },
    async handleGetData(id) {
      this.isLoading = true

      this.data = {
        name: '',
        properties: [],
      }

      try {
        // const response = await getCategoryDetail(id)

        // if (response?.data) {
        //   this.data = {
        //     name: response.data.name,
        //     properties: response.data.properties,
        //   }
        // }
      } finally {
        this.isLoading = false
      }
    },
    async handleSendForm(values) {
      if (this.categoryId) {
        this.isSubmiting = true
        this.modal.setLoadingOn()

        // TODO: add api here to Edit category
        try {
        //   const response = await editCategory(this.categoryId, values)
        //   if (response?.success) {
        //     this.toast.success(this.$t('common.editSuccessMessage'))
        //     this.$emit('resetHandleGetData')
        //   }
        } finally {
          this.modal.setLoadingOff()
          this.isSubmiting = false
          this.handleCloseModal()
        }
      } else {
        const body = {
          name: values.name,
          properties: values.properties
        }
        this.isSubmiting = true
        this.modal.setLoadingOn()

        try {
        //   const response = await createCategory(body)
        //   if (response?.success) {
        //     this.toast.success(this.$t('common.addSuccessMessage'))
        //     this.$emit('resetHandleGetData')
        //   }
        } finally {
          this.modal.setLoadingOff()
          this.isSubmiting = false
          this.handleCloseModal()
        }
      }
    },
    handleCloseModal() {
      this.modal.closeModal()
      this.handleResetForm()
    },
    handleResetForm() {
      this.data = {
        name: '',
        properties: [],
      }
      this.properyInput = ''
    },
    handleAddProperty() {
      if (!EmptyOrWhiteSpace.test(this.properyInput)) {
        // TODO: check if name existed, then push new property with right format
        const listPropertyInputs =
          toRaw(this.data.properties).map((item) => (item.name))

        if (!listPropertyInputs.includes(this.properyInput)) {
          this.data.properties.push({ name: this.properyInput })
        } else {
          this.toast.error(this.$t('devices.add.errorAddProperty'))
        }
        this.properyInput = ''
      } else {
        this.properyInput = ''
      }

      this.formRef.validate()
    },
    handleRemoveProperty(index) {
      if (index >= 0) {
        this.data.properties.splice(index, 1)
      }

      this.formRef.validate()
    },
  },
  created() {
    this.createFormSchema()
  },
}
</script>
