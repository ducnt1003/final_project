<template>
  <label for="perPage">{{ $t('common.display') }}:</label>
  <select
    @change="handleChange"
    id="perPage"
    name="perPage"
    class="form-select d-inline-block w-auto ms-1"
  >
    <option
      v-for="page in perPageOptions"
      :key="page"
      :value="page"
      :selected="page === selected"
    >
      {{ page }}
    </option>
  </select>
</template>

<script>
import perPageOptions from '@/configs/common-table/PerPageOptions'

export default {
  name: 'ItemsPerPageSelect',
  emits: ['itemSelect'],
  props: {
    selected: {
      type: Number,
      required: false,
      default: 10,
    },
  },
  setup() {
    return {
      perPageOptions,
    }
  },
  methods: {
    handleChange(event) {
      if (event.target.value) {
        this.$emit('itemSelect', parseInt(event.target.value))
      }
    },
  },
}
</script>
