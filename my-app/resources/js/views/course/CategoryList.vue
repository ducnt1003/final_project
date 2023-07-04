<template>
  <ContentCard>
    <template #title>Danh mục</template>

    <div class="d-flex justify-content-end mb-3">
      <CButton
        color="success"
        class="text-white"
        @click="handleOpenCategoryModal()"
      >
        {{ $t('devices.addCategory.title') }}
      </CButton>
    </div>

    <!-- Filters -->
    <Filters isOpen @submit="onSubmitFilters" @resetFilters="onResetFilters">
      <CRow>
        <CCol xs="12" class="mb-3">
          <Field
            as="CFormInput"
            name="name"
            placeholder="Tìm kiếm"
            v-model="searchedName"
          />
        </CCol>
      </CRow>
    </Filters>

    <!-- Category Card -->
    <template v-if="!isLoading && datas.length > 0">
      <CCard v-for="category in datas" :key="category.id" class="mt-3">
        <CCardBody class="btn">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1 text-start fw-bold">
              {{ category?.name }}
            </div>
            <div class="d-none d-sm-block" style="z-index: 10">
              <CButton
                color="light"
                shape="rounded-pill"
                class="ms-2"
                @click="handleEditClick(category?.id)"
              >
                <font-awesome-icon icon="fa-solid fa-pencil" />
              </CButton>

              <CButton
                color="light"
                shape="rounded-pill"
                class="ms-2"
                @click="handleDeleteClick(category?.id)"
              >
                <font-awesome-icon icon="fa-solid fa-trash" />
              </CButton>
            </div>
            <router-link
              :to="{ name: 'CourseList', params: { categoryId: category.id } }"
              class="stretched-link"
              style="z-index: 1"
            />
          </div>
        </CCardBody>

        <CCardFooter
          class="d-block d-sm-none bg-transparent"
          style="z-index: 10"
        >
          <CRow>
            <CCol xs="6">
              <div class="d-grid">
                <CButton
                  color="light"
                  shape="rounded-pill"
                  class="ms-2"
                  @click="handleEditClick(category?.id)"
                >
                  <CIcon icon="cil-pencil" />
                </CButton>
              </div>
            </CCol>

            <CCol xs="6">
              <div class="d-grid">
                <CButton
                  color="light"
                  shape="rounded-pill"
                  class="ms-2"
                  @click="handleDeleteClick(category?.id)"
                >
                  <CIcon icon="cil-x-circle" />
                </CButton>
              </div>
            </CCol>
          </CRow>
        </CCardFooter>
      </CCard>
    </template>

    <CCard v-if="isLoading" class="mt-3 btn-light disabled">
      <CCardBody>
        <div class="d-flex align-items-center justify-content-center">
          <CSpinner color="primary" class="me-2" />
          <span>{{ $t('common.loading') }}</span>
        </div>
      </CCardBody>
    </CCard>

    <CCard
      v-if="!isLoading && datas.length < 1"
      class="mt-3 text-center btn-light disabled"
    >
      <CCardBody> {{ $t('common.noData') }} </CCardBody>
    </CCard>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
      <Pagination
        :pages="pages"
        :currentPage="currentPage"
        @pageChange="handlePageChange"
      />
    </div>

    <!-- Category Modal Form -->
    <CategoryFormModal ref="categoryFormModal" />
  </ContentCard>
</template>

<script>
import ContentCard from '@/components/Common/ContentCard.vue'
import Filters from '@/components/Common/Filters.vue'
import { Field } from 'vee-validate'
import Pagination from '@/components/Common/Pagination.vue'
import CategoryFormModal from '@/components/Courses/CategoryFormModal.vue'
import { ref } from '@vue/reactivity'
// import { getCategories, deleteCategory } from '@/services/category'
import { mapActions } from 'vuex'
import { useToast } from 'vue-toastification'

export default {
  components: {
    ContentCard,
    Filters,
    Field,
    Pagination,
    CategoryFormModal,
  },
  setup() {
    const queries = ref({})
    const searchedName = ref('')
    const datas = ref([])
    const pages = ref(10)
    const currentPage = ref(1)
    const isLoading = ref(false)
    const categoryFormModal = ref(null)
    const toast = useToast()

    return {
      queries,
      searchedName,
      datas,
      pages,
      currentPage,
      isLoading,
      categoryFormModal,
      toast,
    }
  },
  methods: {
    ...mapActions(['showDialog']),
    setQueries() {
      this.queries = this.$route.query
      this.setQueriesData()
      this.handleGetData()
    },
    setQueriesData() {
      this.currentPage = parseInt(this.queries?.['page']) || 1
      this.searchedName = this.queries?.['name'] || ''
    },
    onSubmitFilters(values) {
      this.$router.push({
        query: { ...this.queries, page: undefined, ...values },
      })
    },
    onResetFilters() {
      this.$router.push({ query: {} })
    },
    handlePageChange(number) {
      this.$router.push({ query: { ...this.queries, page: number } })
    },
    async handleGetData() {
      this.isLoading = true

      // reset displayed data
      this.datas = []
      this.pages = 1

      const params = {
        page: this.currentPage,
        name: this.searchedName,
      }

      try {
        // const response = await getCategories(params)

        // if (response) {
        //   this.datas = response.data
        //   this.pages = response.last_page
        // }
        this.datas = [
          {
            id: '1',
            name: 'Công nghệ thông tin và truyền thông',
          },
          {
            id: '2',
            name: 'Sư phạm kỹ thuật',
          },
          {
            id: '3',
            name: 'Kinh tế và quản lý',
          },
          {
            id: '4',
            name: 'Ngoại ngữ',
          },
          {
            id: '5',
            name: 'Cơ khí',
          },
          {
            id: '6',
            name: 'Điện - điện tử',
          },
          {
            id: '7',
            name: 'Lý luận chính trị',
          },
          {
            id: '8',
            name: 'Kĩ thuật hóa học',
          },
        ]
      this.pages = 1
      } finally {
        this.isLoading = false
      }
    },
    handleEditClick(id) {
      this.handleOpenCategoryModal(id)
    },
    handleDeleteClick(id) {
      this.showDialog({
        callback: async () => {
        //   const response = await deleteCategory(id)

        //   if (response?.success) {
        //     this.toast.success(this.$t('common.deleteSuccessMessage'))

        //     if (this.datas.length <= 1 && this.currentPage > 1) {
        //       this.$router.push({
        //         query: { ...this.queries, page: this.currentPage - 1 },
        //       })
        //     } else {
        //       this.handleGetData()
        //     }
        //   }
        },
      })
    },
    handleOpenCategoryModal(id = null) {
      this.categoryFormModal.openModal(id)
    },
  },
  created() {
    // watch query change
    this.$watch(
      () => this.$route.query,
      () => {
        if (this.$route.name === 'CourseCategory') {
          this.setQueries()
        }
      },
    )
  },
  mounted() {
    this.setQueries()
  },
}
</script>
