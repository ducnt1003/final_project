<template>
    <ContentCard>
        <template #title>
          Danh sách khóa học
        </template>

        <div
          class="d-flex justify-content-end mb-3">
          <CButton
              color="success"
              class="text-white"
              @click="
              () =>
                $router.push({
                  name: 'DeviceCreate',
                  params: { categoryId },
                })
            "
          >
            Khóa học mới
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
        { data: 'code', title: 'Mã lớp', sortable: true },
        {
          data: 'name',
          title: 'Tên môn',
          sortable: true,
        },
        {
          data: 'teacher',
          title: 'Giảng viên',
          sortable: true,
        },
        {
          data: 'parts',
          title: 'Số buổi',
          sortable: true,
        },
        {
          data: 'num_of_student',
          title: 'Số học sinh',
          sortable: true,
        },
      ]
    },
    setFilters() {
      this.filters = [
        {
          data: 'code',
          type: 'CFormInput',
          label: 'Mã lớp',
        },
        {
          data: 'name',
          type: 'CFormInput',
          label: 'Tên môn',
        },
        {
          data: 'teacher',
          type: 'CFormInput',
          label: 'Giảng viên',
        },
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
    async getCategoryInfo() {
      this.isLoading = true

      // TODO: put api here to get category info
      await new Promise((resolve) =>
        setTimeout(() => {
          console.log('Get category info of id', this.categoryId)
          this.categoryData = {
            name: 'Máy tính',
            properties: [
              {
                name: 'cpu',
                label: 'CPU',
              },
              {
                name: 'ram',
                label: 'RAM',
              },
              {
                name: 'hdd',
                label: 'HDD',
              },
              {
                name: 'ssd',
                label: 'SSD',
              },
              {
                name: 'vga',
                label: 'VGA',
              },
            ],
          }

          resolve()
        }, 500),
      )

      // add category properties to columns
      // this.columns = [
      //   this.columns[0],
      //   this.columns[1],
      //   ...this.categoryData.properties.map((property) => {
      //     return {
      //       data: property.name,
      //       title: property.label,
      //       sortable: true,
      //     }
      //   }),
      //   this.columns[2],
      //   this.columns[3],
      //   this.columns[4],
      // ]

      // add category properties to filters
    //   this.filters = [
    //     this.filters[0],
    //     this.filters[1],
    //     ...this.categoryData.properties.map((property) => {
    //       return {
    //         data: property.name,
    //         label: property.label,
    //         type: 'CFormInput',
    //       }
    //     }),
    //     this.filters[2],
    //     this.filters[3],
    //     this.filters[4],
    //   ]

      // check if user is admin. then add user column
    //   this.columns[this.columns.length] = {
    //     data: 'user',
    //     title: this.$t('devices.common.user'),
    //     sortable: true,
    //   }

    //   this.filters[this.filters.length] = {
    //     data: 'user',
    //     type: 'CFormInput',
    //     label: this.$t('devices.common.user'),
    //   }

      this.isLoading = false
    },
    async handleGetData() {
      this.isLoading = true
      this.pages = 1

      // TODO: Call api to get data here
      await new Promise((resolve) =>
        setTimeout(() => {
          console.log('Get devices from id', this.categoryId)
          this.datas = [
            {
              id: 1,
              code: 'CO-001',
              name: 'Thiết kế giao diện người dùng',
              teacher: 'Nguyễn Văn A',
              parts: 13,
              num_of_student: 50,
            },
            {
              id: 2,
              code: 'CO-002',
              name: 'Kiểm thử và đảm bảo chất lượng phần mềm',
              teacher: 'Nguyễn Văn A',
              parts: 13,
              num_of_student: 50,
            },
            {
              id: 3,
              code: 'CO-003',
              name: 'Kiến trúc phần mềm',
              teacher: 'Nguyễn Văn A',
              parts: 13,
              num_of_student: 50,
            },
            {
              id: 4,
              code: 'CO-004',
              name: 'Phân tích và thiết kế hướng đối tượng',
              teacher: 'Nguyễn Văn A',
              parts: 13,
              num_of_student: 50,
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

    await this.getCategoryInfo()
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
