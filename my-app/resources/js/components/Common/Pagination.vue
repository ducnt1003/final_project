<template>
  <Paginate
    v-if="pages > 1"
    :page-count="pages"
    :initial-page="currentPage"
    :force-page="currentPage"
    :click-handler="clickCallback"
    :prev-text="'<'"
    :next-text="'>'"
    page-link-class="page-link user-select-none"
    prev-link-class="page-link user-select-none"
    next-link-class="page-link user-select-none"
    break-link-class="page-link user-select-none"
    class="m-0"
  />
</template>

<script>
import Paginate from 'vuejs-paginate-next'

export default {
  name: 'Pagination',
  emits: ['pageChange'],
  components: {
    Paginate,
  },
  props: {
    pages: {
      type: Number,
      required: true,
    },
    currentPage: {
      type: Number,
      required: false,
      default: 1,
    },
  },
  methods: {
    clickCallback(number) {
      this.$emit('pageChange', number)
    },
  },
}
</script>
