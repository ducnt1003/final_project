<template>
  <CAccordion :active-item-key="isOpen ? 1 : null" :always-open="isOpen">
    <CAccordionItem :item-key="1">
      <CAccordionHeader>
        <h6 class="m-0">{{ $t('common.filter') }}</h6>
      </CAccordionHeader>
      <CAccordionBody>
        <Form as="CForm" @submit="onSubmit">
          <slot></slot>

          <CRow>
            <CCol xs="12">
              <div
                class="d-grid gap-2 gap-sm-0 d-sm-flex justify-content-sm-end"
              >
                <CButton color="primary" type="submit">
                    <font-awesome-icon icon="fa-solid fa-magnifying-glass" /> {{ $t('common.search') }}
                </CButton>
                <CButton
                  color="light"
                  type="reset"
                  @click="onReset"
                  class="ms-sm-2"
                >
                    <font-awesome-icon icon="fa-solid fa-rotate-right" /> {{ $t('common.resetFilter') }}
                </CButton>
              </div>
            </CCol>
          </CRow>
        </Form>
      </CAccordionBody>
    </CAccordionItem>
  </CAccordion>
</template>

<script>
import { Form } from 'vee-validate'

export default {
  name: 'Filters',
  emits: ['submit', 'resetFilters'],
  components: {
    Form,
  },
  props: {
    isOpen: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  methods: {
    onSubmit(values) {
      this.$emit('submit', values)
    },
    onReset() {
      this.$emit('resetFilters')
    },
  },
}
</script>
