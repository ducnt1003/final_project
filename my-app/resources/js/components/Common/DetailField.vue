<template>
  <CRow class="mb-3">
    <CCol sm="5" lg="4" xl="3">
      <slot name="label">
        <h6 class="m-0">{{ label }}:</h6>
      </slot>
    </CCol>
    <CCol sm="7" lg="8" xl="9">
      <slot name="value">
        <span class="text-break">
          {{ value }}
        </span>
      </slot>
    </CCol>
  </CRow>
</template>

<script>
export default {
  name: 'DetailField',
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: [String, Number, Object, Array],
      required: false,
      default: '',
    },
  },
}
</script>
