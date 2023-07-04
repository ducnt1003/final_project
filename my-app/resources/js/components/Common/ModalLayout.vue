<template>
  <CModal
    :scrollable="scrollable"
    :keyboard="keyboard"
    :backdrop="backdrop"
    :alignment="alignment"
    :size="size"
    :visible="visible"
    @close="closeModal"
  >
    <CModalHeader v-if="!hideHeader" :close-button="displayCloseButton">
      <CModalTitle component="h3" class="flex-grow-1 text-center">
        <slot name="title" />
      </CModalTitle>
    </CModalHeader>

    <CModalBody>
      <slot />
    </CModalBody>

    <CModalFooter v-if="!hideFooter">
      <slot name="footer" />
    </CModalFooter>
  </CModal>
</template>

<script>
import { ref } from '@vue/reactivity'

export default {
  name: 'ModalLayout',
  props: {
    scrollable: {
      type: Boolean,
      required: false,
      default: true,
    },
    backdrop: {
      type: [String, Boolean],
      required: false,
      default: true,
    },
    keyboard: {
      type: Boolean,
      required: false,
      default: true,
    },
    displayCloseButton: {
      type: Boolean,
      required: false,
      default: true,
    },
    size: {
      type: String,
      required: false,
      default: null,
    },
    alignment: {
      type: String,
      required: false,
      default: 'center',
    },
    hideHeader: {
      type: Boolean,
      required: false,
      default: false,
    },
    hideFooter: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  setup() {
    const visible = ref(false)
    const isLoading = ref(false)

    return {
      visible,
      isLoading,
    }
  },
  methods: {
    openModal() {
      this.visible = true
    },
    closeModal() {
      if (!this.isLoading) {
        this.visible = false
      }
    },
    setLoadingOn() {
      this.isLoading = true
    },
    setLoadingOff() {
      this.isLoading = false
    },
  },
}
</script>
