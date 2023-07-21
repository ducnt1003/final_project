<template>
    <ContentCard>
        <template #title>
          Danh sách định hướng
        </template>

        <div
          class="d-flex justify-content-end mb-3">
          <CButton
              color="success"
              class="text-white"
              @click="
              () =>
                $router.push({
                  name: 'DirectionCreate',
                })
            "
          >
            Định hướng mới
          </CButton>
        </div>

        <DataTable
            :columns="columns"
            :datas="datas"
            :queries="queries"
            :filters="filters"
            :pages="pages"
            :isLoading="isLoading"
            :defaultSort="defaultSort"
            clickable
            @viewClick="handleView"
            :hasEdit="true"
            @editClick="handleEdit"
            :hasDelete="true"
            @deleteClick="handleDelete"
        >
        </DataTable>
      </ContentCard>
</template>
<script>
import ContentCard from '@/components/Common/ContentCard.vue'
import DataTable from '@/components/Common/DataTable.vue'
import { useRoute } from 'vue-router'
import { ref } from '@vue/reactivity'
import { mapActions } from 'vuex'
import { useToast } from 'vue-toastification'
export default {
    components: {
    ContentCard,
    DataTable,
  },
  setup() {
    const columns = []
    const queries = ref({})
    const filters = ref([])
    const isLoading = ref(false)
    const datas = ref([])
    const pages = ref(1)
    const defaultSort = ['id', 'asc']
    const categoryId = useRoute().params.categoryId
    const categoryData = ref(null)
    const toast = useToast()

    return {
        columns,
        queries,
        filters,
        isLoading,
        datas,
        pages,
        defaultSort,
        categoryId,
        categoryData,
        toast
    }
  },
  methods: {
    ...mapActions(['showDialog']),
    setColumns() {
      this.columns = [
        {
          data: 'name',
          title: 'Tên định hướng',
          sortable: true,
        },
        {
          data: 'expert',
          title: 'Chuyên gia',
          sortable: true,
        },
        {
          data: 'num_of_student',
          title: 'Số người quan tâm',
          sortable: true,
        },
      ]
    },
    setFilters() {
      this.filters = [
        {
          data: 'name',
          type: 'CFormInput',
          label: 'Tên định hướng',
        },
        {
          data: 'expert',
          type: 'CFormInput',
          label: 'Chuyên gia',
        }
        // {
        //   data: 'parts',
        //   type: 'CFormSelect',
        //   label: s,
        //   options: this.conditions,
        // },
        // {
        //   data: 'status',
        //   type: 'CFormSelect',
        //   label: this.$t('devices.common.assetStatus'),
        //   options: this.statuses,
        // },
      ]
    },
    setQueries() {
      this.queries = this.$route.query
    },
    async handleGetData() {
      this.isLoading = true
      this.pages = 1

      // TODO: Call api to get data here
      await new Promise((resolve) =>
        setTimeout(() => {
          this.datas = [
            {
              id: 1,
              name: 'BackEnd Developer',
              expert: 'Nguyễn Văn Mạnh',
              num_of_student: 50,
            },
            {
              id: 2,
              name: 'FrontEnd Developer',
              expert: 'Nguyễn Văn Tiến',
              num_of_student: 50,
            },
            {
              id: 3,
              name: 'Bussiness Analyst',
              expert: 'Vương Thị Linh',
              num_of_student: 20,
            },
            {
              id: 4,
              name: 'Data Engineer',
              expert: 'Nguyễn Văn Tú',
              num_of_student: 61,
            },
          ]

          this.pages = 1
          resolve()
        }, 500),
      )

      this.isLoading = false
    },
    handleView(event) {
      this.$router.push({
        name: 'DeviceDetail',
        params: { categoryId: this.categoryId, deviceId: event.id },
      })
    },
    handleEdit(event) {
      this.$router.push({
        name: 'DeviceEdit',
        params: { categoryId: this.categoryId, deviceId: event.id },
      })
    },
    handleDelete(event) {
      this.showDialog({
        callback: async () => {
          // TODO: add api here to delete device
          await new Promise((resolve) => {
            console.log('Handle delete id', event.id)

            setTimeout(() => {
              resolve()
            }, 1000)
          })

          this.toast.success(this.$t('common.deleteSuccessMessage'))

          if (this.datas.length <= 1 && this.currentPage > 1) {
            this.$router.push({
              query: { ...this.queries, page: this.currentPage - 1 },
            })
          } else {
            this.handleGetData()
          }
        },
      })
    },
  },
  async created() {
    this.setFilters()
    this.setColumns()
    this.setQueries()
    await this.handleGetData()

    // watch query change
    this.$watch(
      () => this.$route.query,
      async () => {
        if (this.$route.name === 'CourseList') {
          this.setQueries()
          await this.handleGetData()
        }
      },
    )
  },

}
</script>
